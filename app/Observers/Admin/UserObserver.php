<?php

namespace App\Observers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function saved(User $user): void
    {
        if ($user->isDirty('avatar')) {
            if (! is_null($user->avatar) && Storage::disk(getCurrentDisk())->exists($user->avatar)) {
                if (! is_null($user->getOriginal('avatar'))) {
                    Storage::disk(getCurrentDisk())->delete($user->getOriginal('avatar'));
                }
            }
        }

        if ($user->isDirty('cover_image')) {
            if (! is_null($user->cover_image) && Storage::disk(getCurrentDisk())->exists($user->cover_image)) {
                if (! is_null($user->getOriginal('cover_image'))) {
                    Storage::disk(getCurrentDisk())->delete($user->getOriginal('cover_image'));
                }
            }
        }
    }

    public function deleted(User $user): void
    {
        if (! is_null($user->avatar)) {
            Storage::disk(getCurrentDisk())->delete($user->avatar);
        }

        if (! is_null($user->cover_image)) {
            Storage::disk(getCurrentDisk())->delete($user->cover_image);
        }
    }
}
