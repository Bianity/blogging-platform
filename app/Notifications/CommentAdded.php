<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Story;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAdded extends Notification
{
    use Queueable;

    // private Comment $comment;
    // public Article $article;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Story $story, Comment $comment)
    {
        $this->story = $story;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('A comment was posted on your article')
            ->markdown('emails.comment-added', [
                // 'comment' => $this->comment,
                // 'article' => $this->article,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'new_comment',
            'comment_id' => $this->comment->id,
            'comment_body' => $this->comment->comment,
            'user_name' => $this->comment->user->name,
            'user_avatar' => $this->comment->user->getAvatar(),
            'story_id' => $this->comment->commentable_id,
            'story_title' => $this->story->title,
            'story_slug' => $this->story->slug,
        ];
    }
}
