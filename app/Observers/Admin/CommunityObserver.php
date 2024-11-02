<?php

namespace App\Observers\Admin;

use App\Models\Community;
use Illuminate\Support\Facades\Storage;

class CommunityObserver
{
    public function saved(Community $community): void
    {
        if ($community->isDirty('avatar')) {
            if (! is_null($community->avatar) && Storage::disk(getCurrentDisk())->exists($community->avatar)) {
                if (! is_null($community->getOriginal('avatar'))) {
                    Storage::disk(getCurrentDisk())->delete($community->getOriginal('avatar'));
                }
            }
        }

        if ($community->isDirty('cover_image')) {
            if (! is_null($community->cover_image) && Storage::disk(getCurrentDisk())->exists($community->cover_image)) {
                if (! is_null($community->getOriginal('cover_image'))) {
                    Storage::disk(getCurrentDisk())->delete($community->getOriginal('cover_image'));
                }
            }
        }
    }

    public function deleted(Community $community): void
    {
        if (! is_null($community->avatar)) {
            Storage::disk(getCurrentDisk())->delete($community->avatar);
        }

        if (! is_null($community->cover_image)) {
            Storage::disk(getCurrentDisk())->delete($community->cover_image);
        }
    }
}
