<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Post|Comment $data;
    
    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        // Determine the type (post or comment) and adjust the channel name
        if ($this->data instanceof \App\Models\Post) {
            return new PrivateChannel('like-channel.post.' . $this->data->id);
        } elseif ($this->data instanceof \App\Models\Comment) {
            return new PrivateChannel('like-channel.comment.' . $this->data->id);
        }
    }

    /**
     * Broadcast data with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'data_id' => $this->data->id,
            'likes_count' => $this->data->likes_count,
            'type' => $this->data instanceof \App\Models\Post ? 'post' : 'comment',
        ];
    }

}
