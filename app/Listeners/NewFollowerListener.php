<?php

namespace App\Listeners;

use App\Events\Follow\Followed;
use App\Models\User;
use App\Notifications\NewUserFollowNotification;

class NewFollowerListener
{
    public function handle(Followed $event): void
    {
        $user = User::find($event->followable_id);
        $follower = User::find($event->follower_id);

        $user->notify(new NewUserFollowNotification($follower));
    }
}
