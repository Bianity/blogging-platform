<?php

namespace App\Models;

use App\Models\Traits\Favoriteable;
use App\Models\Traits\Votable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Mews\Purifier\Casts\CleanHtmlInput;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Story extends Model implements Viewable, HasMedia
{
    use HasFactory;
    use InteractsWithViews;
    use Sluggable;
    use Votable;
    use Taggable;
    use InteractsWithMedia;
    use Favoriteable;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
        'meta' => 'array',
        'title'  => CleanHtmlInput::class,
        'subtitle'  => CleanHtmlInput::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function () {
            Cache::forget('featuredStories');
            Cache::forget('popularTags');
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured-image')->singleFile();
        $this->addMediaCollection('story-audio')->singleFile();
    }

    // RELATIONS

    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function allComments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class, 'story_id');
    }

    public function isPublished(): bool
    {
        return ! $this->isNotPublished();
    }

    public function isNotPublished(): bool
    {
        return $this->published_at === null;
    }

    public function isCommunities(): bool
    {
        return $this->community_id !== null;
    }

    public function isPinned(): bool
    {
        return (bool) $this->is_pinned;
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotPinned(Builder $query): Builder
    {
        return $query->where('is_pinned', false);
    }

    public function userPinnedStories()
    {
        return self::where('user_id', '=', getCurrentUser()->id)->published()->pinned()->get();
    }

    public function getShortContentAttribute()
    {
        return substr($this->body, 0, random_int(150, 300)).'...';
    }

    public function readTime()
    {
        $minutes = round(str_word_count(strip_tags($this->body)) / 100);

        return ($minutes > 1) ? $minutes.' '.__('minutes read') : $minutes.' '.__('minute read');
    }

    public function readTimeCount()
    {
        $minutes = round(str_word_count(strip_tags($this->body)) / 100);

        return intval($minutes);
    }

    public function getReadableDateAttribute()
    {
        if (\Carbon\Carbon::now() > $this->created_at->addDays(7)) {
            $readableDate = $this->created_at->toFormattedDateString();
        } else {
            $readableDate = $this->created_at->diffForHumans();
        }

        return $readableDate;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeNotPublished(Builder $query): Builder
    {
        return $query->whereNull('published_at');
    }

    public function featuredImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', '=', 'featured-image');
    }

    public function storyAudio(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', '=', 'story-audio');
    }
}
