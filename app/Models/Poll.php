<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Mews\Purifier\Casts\CleanHtmlInput;

class Poll extends Model
{
    protected $guarded = [];

    protected $casts = [
        'poll_ends' => 'datetime',
        'question'  => CleanHtmlInput::class,
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class, 'story_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(PollChoice::class);
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function displayHumanTimeLeft()
    {
        $now = Carbon::now();
        if ($this->poll_ends >= $now) {
            return $now->diffInHours($this->poll_ends).Str::plural(__(' hour'), $now->diffInHours($this->poll_ends)).__(' left');
        } else {
            return __('Poll ended').' '.$this->poll_ends->toFormattedDateString();
        }
    }
}
