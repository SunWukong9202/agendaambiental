<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class NotificationsTrigger extends Component
{
    public $unreadCount = 0;

    private function getNotificationsQuery()
    {
        $user = User::find(auth()->user()->id);
        return $user->notifications()->where('data->format', 'filament');
    }

    public function getUnreadNotificationsCount()
    {
        $this->unreadCount = $this->getNotificationsQuery()->unread()->count();
    }
    
    public function render()
    {
        return view('livewire.notifications-trigger');
    }
}
