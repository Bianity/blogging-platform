<?php

namespace App\Events\Follow;

use App\Models\Followable;

class Event
{
    public int|string $followable_id;

    public int|string $followable_type;

    public int|string $follower_id;

    public int|string $user_id;

    protected Followable $relation;

    public function __construct(Followable $follower)
    {
        $this->follower_id = $this->user_id = $follower->{\config('follow.user_foreign_key', 'user_id')};
        $this->followable_id = $follower->followable_id;
        $this->followable_type = $follower->followable_type;
    }
}
