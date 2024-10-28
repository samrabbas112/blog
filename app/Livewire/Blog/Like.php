<?php

namespace App\Livewire\Blog;

use App\Events\LikeEvent;
use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class Like extends Component
{
    public Post|Comment $data;
    public $likesCount = 0;

    public function mount(Post|Comment $data)
    {
       $this->data = $data;
       $this->likesCount = $data->likes_count;
    }

    public function like()
    {
        $user = auth()->user();

        if ($user) {
            $like = $this->data->likes()->where('user_id', $user->id)->first();
        //    dump($this->data->likes()->get());
            if ($like) {
                // Unlike
                $like->delete();
                $this->data->likes_count--;
            } else {
                // Like
                $this->data->likes()->create(['user_id' => $user->id]);
                $this->data->likes_count++;
            }

            $this->data->save();
            $this->likesCount = $this->data->likes_count;

            // Broadcast to others
            broadcast(new LikeEvent($this->data))->toOthers();
        }
    }
    public function getListeners()
    {
        // Dynamically listen to post or comment channels
        $channelType = $this->data instanceof \App\Models\Post ? 'post' : 'comment';
    
        return [
            "echo-private:like-channel.{$channelType}.{$this->data->id},LikeEvent" => 'refreshLikes',
        ];
    }
    
    public function refreshLikes($eventData)
    {
        $this->likesCount = $eventData['likes_count'];
    }
    
    public function render()
    {
        return view('livewire.blog.like');
    }
}
