<?php

namespace App\Livewire;

use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;

trait DBNotifications {

    public function buildDBNotification($title, array $actions = [], $body = null): Notification|null
    {

        $notification = Notification::make()
            ->actions([
                NotificationAction::make('markAsRead')
                    ->translateLabel()
                    ->link()
                    ->markAsRead(),
                
                NotificationAction::make('markAsUnread')
                    ->translateLabel()
                    ->link()
                    ->markAsUnread(),

                ...$actions
            ]);

        if($title) {
            $notification->title($title);
        }

        if($body) {
            $notification->body($body);
        }

        return $notification;
    }

}