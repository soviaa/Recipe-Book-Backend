<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class UserFollowed implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;

    public $message;

    public $userPhoto;
    public $userId;

    public $fullname;

    public function __construct($message, $userId, $userPhoto, $fullname)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->userPhoto = $userPhoto;
        $this->fullname = $fullname;
    }

    public function broadcastOn(): string
    {
        return new Channel('my-channel' . $this->userId);

    }

    public function broadcastAs(): string
    {
        return 'my-event' . $this->userId;
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'userId' => $this->userId,
            'userPhoto' => $this->userPhoto,
            'fullname' => $this->fullname,
        ];
    }

}
