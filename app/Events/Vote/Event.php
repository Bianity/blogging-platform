<?php

namespace App\Events\Vote;

use App\Models\Vote;

class Event
{
    public Vote $vote;

    /**
     * Event constructor.
     */
    public function __construct(Vote $vote)
    {
        $this->vote = $vote;
    }
}
