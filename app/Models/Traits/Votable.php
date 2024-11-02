<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Votable
{
    public function hasBeenVotedBy(Model $user): bool
    {
        if (\is_a($user, config('auth.providers.users.model'))) {
            if ($this->relationLoaded('voters')) {
                return $this->voters->contains($user);
            }

            return ($this->relationLoaded('votes') ? $this->votes : $this->votes())
                ->where(\config('vote.user_foreign_key'), $user->getKey())->count() > 0;
        }

        return false;
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(config('vote.vote_model'), 'votable');
    }

    public function upvotes(): MorphMany
    {
        return $this->votes()->where('votes', '>', 0);
    }

    public function downvotes(): MorphMany
    {
        return $this->votes()->where('votes', '<', 0);
    }

    public function voters()
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('vote.votes_table'),
            'votable_id',
            config('vote.user_foreign_key')
        )->where('votable_type', $this->getMorphClass())->withPivot(['votes']);
    }

    public function upvoters(): BelongsToMany
    {
        return $this->voters()->where('votes', '>', 0);
    }

    public function downvoters(): BelongsToMany
    {
        return $this->voters()->where('votes', '<', 0);
    }

    public function appendsVotesAttributes($attributes = ['total_votes', 'total_upvotes', 'total_downvotes'])
    {
        $this->append($attributes);

        return $this;
    }

    public function getTotalVotesAttribute()
    {
        return abs($this->attributes['total_votes'] ?? $this->totalVotes());
    }

    public function getTotalUpvotesAttribute()
    {
        return abs($this->attributes['total_upvotes'] ?? $this->totalUpvotes());
    }

    public function getTotalDownvotesAttribute()
    {
        return abs($this->attributes['total_downvotes'] ?? $this->totalDownvotes());
    }

    public function totalVotes()
    {
        return abs($this->votes()->sum('votes'));
    }

    public function totalUpvotes()
    {
        return $this->votes()->where('votes', '>', 0)->sum('votes');
    }

    public function totalDownvotes()
    {
        return $this->votes()->where('votes', '<', 0)->sum('votes');
    }

    public function scopeWithTotalVotes(Builder $builder): Builder
    {
        return $builder->withSum('votes as total_votes', 'votes');
    }

    public function scopeWithTotalUpvotes(Builder $builder): Builder
    {
        return $builder->withSum(['votes as total_upvotes' => fn ($q) => $q->where('votes', '>', 0)], 'votes');
    }

    public function scopeWithTotalDownvotes(Builder $builder): Builder
    {
        return $builder->withSum(['votes as total_downvotes' => fn ($q) => $q->where('votes', '<', 0)], 'votes');
    }

    public function scopeWithVotesAttributes(Builder $builder)
    {
        $this->scopeWithTotalVotes($builder);
        $this->scopeWithTotalUpvotes($builder);
        $this->scopeWithTotalDownvotes($builder);
    }

    public function isVotedByUser($user, $vote)
    {
        return $this->votes()->where([
            'user_id' => $user->id,
            'votes' => $vote,
        ])->exists();
    }
}
