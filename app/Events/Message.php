<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $user;
    public $message;
    public $created_at;
    public $updated_at;

    /**
     * Create a new event instance.
     */
    public function __construct($id, $user, $message, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user = $user;
        $this->message = $message;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel("chatroom");
    }
}
