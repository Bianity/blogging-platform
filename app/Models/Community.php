<?php

namespace App\Models;

use App\Models\Traits\Followable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Casts\CleanHtmlInput;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Community extends Model implements HasMedia
{
    use Sluggable;
    use Taggable;
    use InteractsWithMedia;
    use Followable;

    protected $guarded = [];

    protected $casts = [
        'name'  => CleanHtmlInput::class,
        'description'  => CleanHtmlInput::class,
        'rules'  => CleanHtmlInput::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function () {
            Cache::forget('communities');
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('community-avatar')->singleFile();
        $this->addMediaCollection('community-cover-image')->singleFile();
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatar()
    {
        if (! $this->avatar) {
            return 'https://avatars.dicebear.com/api/identicon/'.urlencode($this->name()).'.svg';
        }

        return Storage::disk(getCurrentDisk())->url($this->avatar);
    }

    public function getCoverImage()
    {
        if (! $this->cover_image) {
            return asset('images/cover_default.jpg');
        }

        return Storage::disk(getCurrentDisk())->url($this->cover_image);
    }
}
