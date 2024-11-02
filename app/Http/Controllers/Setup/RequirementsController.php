<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class RequirementsController extends Controller
{
    public function index()
    {
        $php_version = '8.1';

        $results = [
            'php_version' => [
                'acceptable' => version_compare(PHP_VERSION, $php_version, '>='),
                'current'    => phpversion(),
                'minimal'    => $php_version,
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

        return view('setup.requirements', compact('success', 'results'));
    }
}
