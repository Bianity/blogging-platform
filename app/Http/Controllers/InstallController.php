<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\CreateNewAdminController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PDOException;
use Spatie\Permission\Models\Role;

class InstallController extends Controller
{
    protected $dbConfig;

    public function index()
    {
        return Inertia::render('Installer/Index');
    }

    public function license()
    {
        Artisan::call('optimize:clear');

        return Inertia::render('Installer/License');
    }

    public function storeLicense(Request $request)
    {
        $request->validate([
            'license_key' => 'required',
        ]);

        if (isPurchaseCode($request->license_key)) {
            $result = activatePurchaseCode($request->license_key);

            if (isset($result['buyer']) && $result['buyer'] === true) {
                session()->put('license_key', $request->license_key);

                return to_route('installer.requirements');
            } else {
                toast_warning(__('Activation limit exceeded or purchase code is invalid'));

                return back();
            }
        } else {
            toast_warning(__('Invalid purchase code'));

            return back();
        }
    }

    public function requirements()
    {
        $php_version = '8.2';

        $results = [
            'php_version' => [
                'acceptable' => version_compare(PHP_VERSION, $php_version, '>='),
                'current' => phpversion(),
                'minimal' => $php_version,
            ],
            'extensions' => [
                'bcmath' => extension_loaded('bcmath'),
                'fileinfo' => extension_loaded('fileinfo'),
                'ctype' => extension_loaded('ctype'),
                'exif' => extension_loaded('exif'),
                'json' => extension_loaded('json'),
                'mbstring' => extension_loaded('mbstring'),
                'openssl' => extension_loaded('openssl'),
                'intl' => extension_loaded('intl'),
                'gd' => extension_loaded('gd'),
                'pdo_mysql' => extension_loaded('pdo_mysql'),
                'tokenizer' => extension_loaded('tokenizer'),
                'xml' => extension_loaded('xml'),
            ],
            'writable' => [
                'env_writable' => File::isWritable(base_path('.env')),
                'storage_writable' => File::isWritable(storage_path()) && File::isWritable(storage_path('logs')),
            ],
        ];

        $success = ! in_multidimensional_array(false, $results);

        return Inertia::render('Installer/Requirements', compact('results', 'success'));
    }

    public function database()
    {
        return Inertia::render('Installer/Database');
    }

    public function storeDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_name' => 'required|string',
            'db_user' => 'required|string',
            'db_password' => 'nullable|string',
            'db_overwrite_data' => 'boolean',
        ]);

        $this->temporaryDatabaseConnection([
            'db_host' => $request->db_host,
            'db_port' => $request->db_port,
            'db_name' => $request->db_name,
            'db_user' => $request->db_user,
            'db_password' => $request->db_password,
        ]);

        if ($this->databaseHasData() && ! $request->db_overwrite_data) {
            $request->session()->flash('db_alert', __('Caution! We found data in the database you specified! Please make sure that you have a backup of that database and confirm the deletion of all data.'));

            return back();
        }

        try {
            config([
                'database.connections.mysql' => [
                    'driver' => 'mysql',
                    'host' => $request->input('db_host'),
                    'port' => $request->input('db_port'),
                    'database' => $request->input('db_name'),
                    'username' => $request->input('db_user'),
                    'password' => $request->input('db_password'),
                ],
            ]);
            DB::reconnect('mysql');

            DB::connection('mysql')->getPdo();
        } catch (\Exception $e) {
            $alert = __('Database could not be configured. Please check your connection details. Details:').' '.$e->getMessage();

            toast_error($alert);

            return back();
        }

        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
            '--no-interaction' => true,
        ]);

        setEnvironmentValue([
            'db_host' => $request->input('db_host'),
            'db_port' => $request->input('db_port'),
            'db_database' => $request->input('db_name'),
            'db_username' => $request->input('db_user'),
            'db_password' => $request->input('db_password'),
            'app_url' => getAppURL(),
        ]);

        if (app()->environment('production')) {
            Artisan::call('config:cache');
        }

        return to_route('installer.account');
    }

    public function temporaryDatabaseConnection(array $credentials): void
    {
        $this->dbConfig = config('database.connections.mysql');
        $this->dbConfig['host'] = $credentials['db_host'];
        $this->dbConfig['port'] = $credentials['db_port'];
        $this->dbConfig['database'] = $credentials['db_name'];
        $this->dbConfig['username'] = $credentials['db_user'];
        $this->dbConfig['password'] = $credentials['db_password'];

        Config::set('database.connections.setup', $this->dbConfig);
    }

    public function databaseHasData(): bool
    {
        try {
            $tables = DB::connection('setup')->select('SHOW TABLES');
        } catch (PDOException $e) {
            Log::error($e->getMessage());

            return false;
        }

        return count($tables) > 0;
    }

    public function upgrade()
    {
        return Inertia::render('Installer/Upgrade');
    }

    public function upgradeApp(Request $request)
    {
        $request->validate([
            'upgrade_confirmation' => 'required|boolean',
        ]);

        try {
            $hasTables = count(DB::select('SHOW TABLES')) > 0;
        } catch (\Exception $e) {
            $alert = __('Database could not be configured. Please check your connection details. Details:').' '.$e->getMessage();

            toast_error($alert);

            return back();
        }

        if ($hasTables && $request->upgrade_confirmation) {
            Artisan::call('migrate', [
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'SettingSeeder',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'RolesSeeder',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'PermissionsSeeder',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'LevelSeeder',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'BadgeSeeder',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'AdSeeder',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--class' => 'UserSettingsSeeder',
                '--force' => true,
            ]);

            DB::table('notifications')->truncate();

            User::where('id', 1)->first()->assignRole(Role::where('name', 'administrator')->first());
            User::where('id', '!=', 1)->get()->each(function ($user) {
                $user->assignRole(Role::where('name', 'author')->first());
            });

            return to_route('installer.complete');
        }
    }

    public function account()
    {
        return Inertia::render('Installer/Account');
    }

    public function storeAccount(Request $request)
    {
        $user = (new CreateNewAdminController())->create($request->input());

        $user->profile()->create();

        $user->assignRole('administrator');

        $user->update([
            'preference_settings' => [
                'show_nsfw' => true,
                'blur_nsfw' => true,
                'open_posts_new_tab' => false,
            ],
            'notify_settings' => [
                'new_comments' => true,
                'replies_comments' => true,
                'liked' => true,
                'new_follower' => true,
                'mentions' => true,
            ],
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->route('installer.complete');
    }

    public function complete()
    {
        Artisan::call('key:generate', [
            '--force' => true,
        ]);

        Artisan::call('storage:link', [
            '--force' => true,
        ]);

        session()->forget('license_key');

        file_put_contents(storage_path('installed'), '');

        return Inertia::render('Installer/Complete');
    }
}
