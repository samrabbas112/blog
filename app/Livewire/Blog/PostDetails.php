<?php

namespace App\Livewire\Blog;

use App\Events\CommentEvent;
use App\Events\LikeEvent;
use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;

class PostDetails extends Component
{
    public Post $post;
    public $replyContent;
    public $likesCount;
    public $comment ;

    // protected $listeners = [
    //     'echo-private:like-channel.{post},LikeEvent' => 'listenForLike',
    // ];


    public function mount($postId)
    {
        $this->post = Post::find($postId);
        $this->likesCount = $this->post->likes_count;

    }

    public function render()
    {
        return view('livewire.blog.post-details');
    }

    public function submitReply()
    {
        $this->comment = Comment::create([
            'body' => $this->replyContent,
            'user_id' => auth('web')->user()->id,
            'commentable_id' => $this->post->id,
            'commentable_type' => Post::class
        ]);
        broadcast(new CommentEvent($this->comment))->toOthers(); 

    }


    public function getListeners()
    {
        return [
            "echo-private:comment-channel.{$this->comment},CommentEvent" => 'refreshComments',
        ];
    }

    public function refreshComments($eventData)
    {
        dd($eventData);
        $this->emit('refreshSingleComment', $eventData['comment_id']);
    }

}
