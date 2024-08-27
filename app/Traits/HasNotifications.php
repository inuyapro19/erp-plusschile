<?php
namespace App\Traits;

trait HasNotifications
{
    public function unreadNotificationsCount()
    {
        return $this->unreadNotifications->count();
    }

    public function lastNotificationTime()
    {
        $lastNotification = $this->notifications->last();
        if (!$lastNotification) {
            return null;
        }

        return $lastNotification->created_at->diffForHumans();
    }

    public function newNotificationsWithDate()
    {
        return $this->unreadNotifications->map(function ($notification) {
            return [
                'message' => $notification->data['mensaje'],
                'created_at' => $notification->created_at->diffForHumans()
            ];
        });
    }

    public function markAllNotificationsAsRead()
    {
        $this->unreadNotifications->markAsRead();
    }


}
