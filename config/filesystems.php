<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/uploads'),
            'url' => env('APP_URL').'/uploads',
            'visibility' => 'public',
            'throw' => false,
        ],

        'temp' => [
            'driver' => 'local',
            'root' => storage_path('app/temp'),
            'url' => env('APP_URL').'/temp',
            'visibility' => 'public',
            'throw' => false,
        ],

        'aws' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => false,
            'throw' => false,
        ],

        'dos' => [
            'driver' => 's3',
            'key' => env('DOS_ACCESS_KEY_ID'),
            'secret' => env('DOS_SECRET_ACCESS_KEY'),
            'region' => env('DOS_DEFAULT_REGION'),
            'bucket' => env('DOS_BUCKET'),
            'folder' => env('DOS_FOLDER'),
            'cdn_endpoint' => env('DOS_CDN_ENDPOINT'),
            'url' => env('DOS_URL'),
            'endpoint' => env('DOS_ENDPOINT'),
            'use_path_style_endpoint' => false,
        ],

        'wasabi' => [
            'driver' => 's3',
            'key' => env('WASABI_ACCESS_KEY_ID'),
            'secret' => env('WASABI_SECRET_ACCESS_KEY'),
            'region' => env('WASABI_DEFAULT_REGION', 'eu-central-1'),
            'bucket' => env('WASABI_BUCKET'),
            'endpoint' => env('WASABI_ENDPOINT', 'https://s3.eu-central-1.wasabisys.com/'),
        ],

        'backblaze' => [
            'driver' => 's3',
            'key' => env('B2_APPLICATION_KEY_ID'),
            'secret' => env('B2_APPLICATION_KEY_SECRET'),
            'bucket' => env('B2_BUCKET_NAME'),
            'region' => env('B2_REGION', 'eu-central-003'),
            'endpoint' => env('B2_ENDPOINT', 'https://s3.eu-central-003.backblazeb2.com'),
            'use_path_style_endpoint' => false,
            'options' => [
                'ACL' => '',
            ],
        ],

        'snapshots' => [
            'driver' => 'local',
            'root' => database_path('snapshots'),
        ],
        'tmp-for-tests' => [
            'driver' => 'local',
            'root' => storage_path('app/livewire-tmp'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('uploads') => storage_path('app/uploads'),
        public_path('temp') => storage_path('app/temp'),
    ],

];
