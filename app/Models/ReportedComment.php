<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtmlInput;

class ReportedComment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'message'  => CleanHtmlInput::class,
    ];

    /**
     * Get comment.
     *
     * @return object
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id')->withTrashed();
    }

    /**
     * Get story.
     *
     * @return object
     */
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id')->withTrashed();
    }

    /**
     * Get reporter.
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
