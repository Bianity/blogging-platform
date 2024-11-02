<?php

namespace App\Livewire\Admin\Settings;

use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class CacheManager extends Component
{
    use AuthorizesRequests;

    public function mount(): void
    {
        $this->authorize('access_admin_dashboard');
    }

    // Clear all cache
    public function cacheClearAll()
    {
        Artisan::call('cache:clear');

        Notification::make()
            ->success()
            ->title(__('All cache successfully cleared'))
            ->seconds(10)
            ->send();
    }

    // Clear cache
    public function cacheClear(): void
    {
        Artisan::call('cache:clear');

        Notification::make()
            ->success()
            ->title(__('Application cache successfully cleared'))
            ->seconds(10)
            ->send();
    }

    // Caching view files
    public function viewCaching(): void
    {
        Artisan::call('view:cache');

        Notification::make()
            ->success()
            ->title(__('Application now is caching'))
            ->seconds(10)
            ->send();
    }

    // Clear all compiled view files
    public function viewClearing(): void
    {
        // Clear
        Artisan::call('view:clear');

        Notification::make()
            ->success()
            ->title(__('All compiled view files cleared'))
            ->seconds(10)
            ->send();
    }

    public function render()
    {
        return view('livewire.admin.settings.cache-manager');
    }
}
