<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetupDatabaseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;

class DatabaseController extends Controller
{
    protected $dbConfig;

    public function index()
    {
        return view('setup.database');
    }

    public function store(SetupDatabaseRequest $request): RedirectResponse
    {
        $this->temporaryDatabaseConnection($request->all());

        if ($this->databaseHasData() && ! $request->has('overwrite_data')) {
            $request->session()->flash('alert', __('Caution! We found data in the database you specified! Please make sure that you have a backup of that database and confirm the deletion of all data.'));

            return redirect()->back()->with('data_present', true)->withInput();
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
            $request->session()->flash('alert', $alert);

            return redirect()->back()->withInput();
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

        return redirect()->route('setup.account');
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
            $tables = DB::connection('setup')
                ->getDoctrineSchemaManager()
                ->listTableNames();
        } catch (PDOException $e) {
            Log::error($e->getMessage());

            return false;
        }

        return count($tables) > 0;
    }
}
