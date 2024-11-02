<?php

namespace App\Models;

use App\Models\Traits\Favoriteable;
use App\Models\Traits\Votable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Casts\CleanHtmlInput;

class Comment extends Model
{
    use Votable;
    use Favoriteable;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'comment',
        'parent_id',
        'commentable_id',
        'commentable_type',
        'spam_reports',
    ];

    protected $casts = [
        'comment'  => CleanHtmlInput::class,
    ];

    public function scopeParent(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function story()
    {
        return $this->belongsTo(Story::class, 'commentable_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
