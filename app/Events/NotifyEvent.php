<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notifyId;

    public function __construct($notifyId)
    {
        $this->notifyId = $notifyId;
    }

    public function broadcastOn()
    {
        $notify = Notification::selectColumns(['user_id'])
            ->where('id', $this->notifyId)->first();

        return ['channel-'.str($notify->user_id)];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
