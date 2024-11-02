<?php

namespace App\Models;

use App\Models\Traits\Favoriter;
use App\Models\Traits\Followable;
use App\Models\Traits\Follower;
use App\Models\Traits\Voter;
use App\Notifications\Auth\ResetPasswordQueued;
use App\Notifications\Auth\VerifyEmailQueued;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Mews\Purifier\Casts\CleanHtmlInput;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail, FilamentUser, HasAvatar, HasName
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Voter;
    use Follower;
    use Followable;
    use InteractsWithMedia;
    use Favoriter;
    use HasRoles;
    use SoftDeletes;

    protected $table = 'users';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen' => 'datetime',
        'name'  => CleanHtmlInput::class,
        'username'  => CleanHtmlInput::class,
        'email'  => CleanHtmlInput::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function () {
            Cache::forget('topAuthors');
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')->singleFile();
    }

    public function isLoggedInUser(): bool
    {
        return $this->id() === Auth::id();
    }

    public function isModerator(): bool
    {
        return $this->hasRole('moderator');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('administrator');
    }

    public function isBanned(): bool
    {
        return (bool) $this->is_banned;
    }

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();

        return $password !== '' && $password !== null;
    }

    // Profile
    public function profileBio()
    {
        return $this->profile->bio();
    }

    public function location()
    {
        return $this->profile->location();
    }

    public function company()
    {
        return $this->profile->company();
    }

    public function education()
    {
        return $this->profile->education();
    }

    public function profileWebsite()
    {
        return $this->profile->website();
    }

    public function profileFacebook()
    {
        return $this->profile->facebook();
    }

    public function profileTwitter()
    {
        return $this->profile->twitter();
    }

    public function profileInstagram()
    {
        return $this->profile->instagram();
    }

    public function profileTiktok()
    {
        return $this->profile->tiktok();
    }

    public function profileYoutube()
    {
        return $this->profile->youtube();
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function joinedDate()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function communities(): HasMany
    {
        return $this->hasMany(Community::class);
    }

    public function pollVotes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function getCommunityForMenu()
    {
        return Community::select('name', 'avatar', 'slug')->where('user_id', $this->id)->get();
    }

    public function countCommunities(): int
    {
        return $this->communities()->count();
    }

    public function countStories(): int
    {
        return $this->stories()->published()->count();
    }

    public function getAvatar()
    {
        if (! $this->avatar) {
            if (isset($this->name)) {
                return 'https://avatars.dicebear.com/api/avataaars/'.urlencode($this->name).'.svg?backgroundColor=%23caeaff';
            }

            return 'https://avatars.dicebear.com/api/avataaars/'.urlencode($this->username).'.svg?backgroundColor=%23caeaff';
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

    public function scopeMostStories(Builder $query, int $inLastDays = null)
    {
        return $query->withCount(['stories as stories_count' => function ($query) use ($inLastDays) {
            if ($inLastDays) {
                $query->where('stories.published_at', '>=', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderByDesc('stories_count');
    }

    public function scopeMostStoriesInLastDays(Builder $query, int $days)
    {
        return $query->mostStories($days);
    }

    public function hasPollVoted($pollId)
    {
        return $this->pollVotes()->where('poll_id', $pollId)->count() > 0;
    }

    public function isChosenByUser($userId, $choiceId)
    {
        return $this->pollVotes->where('user_id', $userId)->where('poll_choice_id', $choiceId)->count() > 0;
    }

    // Need __supervisor__ to manage running your job server on the background.

    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new VerifyEmailQueued());
    // }

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPasswordQueued($token));
    // }

    public function getFilamentAvatarUrl(): ?string
    {
        if (! $this->avatar) {
            if (isset($this->name)) {
                return 'https://avatars.dicebear.com/api/avataaars/'.urlencode($this->name).'.svg?backgroundColor=%23caeaff';
            }

            return 'https://avatars.dicebear.com/api/avataaars/'.urlencode($this->username).'.svg?backgroundColor=%23caeaff';
        }

        return Storage::disk(getCurrentDisk())->url($this->avatar);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return auth()->user()->hasRole('administrator');
    }

    public function getFilamentName(): string
    {
        return auth()->user()->name ? $this->name : $this->username;
    }

    public function isOnline()
    {
        return Cache::has('is-online-'.$this->id) ? Cache::has('is-online-'.$this->id) : null;
    }
}
