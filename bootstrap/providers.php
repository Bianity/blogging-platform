<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    CyrildeWit\EloquentViewable\EloquentViewableServiceProvider::class,
    Artesaos\SEOTools\Providers\SEOToolsServiceProvider::class,
    October\Rain\Config\ServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    PragmaRX\Google2FALaravel\ServiceProvider::class,
];
