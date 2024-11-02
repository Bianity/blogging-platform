<?php

namespace App\Livewire\Front;

use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Notifications extends Component
{
    public const NOTIFICATION_THRESHOLD = 10;

    public $notifications;

    public $notificationsCount;

    public $isLoading;

    protected $listeners = ['getNotifications'];

    public function mount()
    {
        $this->notifications = collect([]);
        $this->isLoading = true;
        $this->getNotificationsCount();
    }

    public function getNotifications()
    {
        $this->notifications = auth()->user()->unreadNotifications()->latest()->take(self::NOTIFICATION_THRESHOLD)->get();
        $this->isLoading = false;
    }

    public function getNotificationsCount()
    {
        $this->notificationsCount = auth()->user()->unreadNotifications()->count();

        if ($this->notificationsCount > self::NOTIFICATION_THRESHOLD) {
            $this->notificationsCount = self::NOTIFICATION_THRESHOLD.'+';
        }
    }

    public function markAsRead($notificationId)
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->route('story.show', [
            'story' => $notification->data['story_slug'],
        ]);
    }

    public function markAsReadFollower($notificationId)
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->route('user.show', [
            'user' => $notification->data['username'],
        ]);
    }

    public function clearAllNotifications()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        auth()->user()->unreadNotifications->markAsRead();

        $this->getNotificationsCount();
        $this->getNotifications();
    }

    public function render()
    {
        return view('livewire.front.notifications');
    }
}
