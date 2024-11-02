<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Casts\CleanHtmlInput;

class Profile extends Model
{
    use HasFactory;

    public const TABLE = 'profiles';

    protected $table = self::TABLE;

    protected $fillable = [
        'bio',
        'location',
        'company',
        'education',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
    ];

    protected $casts = [
        'bio'  => CleanHtmlInput::class,
        'location'  => CleanHtmlInput::class,
        'company'  => CleanHtmlInput::class,
        'education'  => CleanHtmlInput::class,
        'website'  => CleanHtmlInput::class,
        'facebook'  => CleanHtmlInput::class,
        'twitter'  => CleanHtmlInput::class,
        'instagram'  => CleanHtmlInput::class,
        'tiktok'  => CleanHtmlInput::class,
        'youtube'  => CleanHtmlInput::class,
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function bio(): ?string
    {
        return $this->bio;
    }

    public function location(): ?string
    {
        return $this->location;
    }

    public function company(): ?string
    {
        return $this->company;
    }

    public function education(): ?string
    {
        return $this->education;
    }

    public function website(): ?string
    {
        return $this->website;
    }

    public function facebook(): ?string
    {
        return $this->facebook;
    }

    public function twitter(): ?string
    {
        return $this->twitter;
    }

    public function instagram(): ?string
    {
        return $this->instagram;
    }

    public function tiktok(): ?string
    {
        return $this->tiktok;
    }

    public function youtube(): ?string
    {
        return $this->youtube;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
