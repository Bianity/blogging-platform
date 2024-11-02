<?php

namespace App\Models;

use App\Events\Vote\VoteCancelled;
use App\Events\Vote\Voted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $dispatchesEvents = [
        'created' => Voted::class,
        'deleted' => VoteCancelled::class,
    ];

    protected $appends = [
        'is_up_vote',
        'is_down_vote',
    ];

    protected $casts = [
        'votes' => 'int',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = \config('vote.votes_table');

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($vote) {
            $userForeignKey = \config('vote.user_foreign_key');
            $vote->{$userForeignKey} = $vote->{$userForeignKey} ?: auth()->id();

            if (\config('vote.uuids')) {
                $vote->{$vote->getKeyName()} = $vote->{$vote->getKeyName()} ?: (string) Str::orderedUuid();
            }
        });
    }

    public function votable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\config('auth.providers.users.model'), \config('vote.user_foreign_key'));
    }

    public function voter(): BelongsTo
    {
        return $this->user();
    }

    public function isUpVote(): bool
    {
        return $this->votes > 0;
    }

    public function isDownVote(): bool
    {
        return $this->votes < 0;
    }

    public function getIsUpVoteAttribute(): bool
    {
        return $this->isUpVote();
    }

    public function getIsDownVoteAttribute(): bool
    {
        return $this->isDownVote();
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('votable_type', app($type)->getMorphClass());
    }

    public function scopeOfVotable(Builder $query, string $type): Builder
    {
        return $this->scopeOfType(...\func_get_args());
    }
}
