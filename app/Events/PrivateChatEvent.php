<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $content;
    public $chat;

    public function __construct($content, $chat)
    {
        $this->content = $content;
        $this->chat = $chat;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('Chat.'.$this->chat['session_id']);
    }
}