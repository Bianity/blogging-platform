<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Artisan;

class InitWizardController extends Controller
{
    public function welcome()
    {
        Artisan::call('optimize:clear');

        return view('setup.welcome');
    }

    public function complete(GeneralSettings $settings)
    {
        Artisan::call('key:generate', [
            '--force' => true,
        ]);

        Artisan::call('storage:link', [
            '--force' => true,
        ]);

        Artisan::call('config:clear');

        if (app()->environment('production')) {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
        }

        $settings->setup_completed = true;
        $settings->save();

        return view('setup.complete');
    }
}
