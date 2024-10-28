<?php

namespace App\Livewire\Blog;

use App\Events\CommentEvent;
use App\Models\Comment as ModelsComment;
use App\Models\Post;
use Livewire\Component;

class Comment extends Component
{
    public Post $post;
    public $comment;
    public $replyContent;
    public $replyToCommentId;

    public function mount($comment, Post $post)
    {
        $this->post = $post;
        $this->comment = $comment;
    }

    public function showReplyBox($commentId)
    {
        $this->replyToCommentId = $commentId;
    }

    public function submitReply($commentId, $type)
    {
        $commentableType = $type == 'post' ? Post::class : ModelsComment::class;
        ModelsComment::create([
            'body' => $this->replyContent,
            'user_id' => auth('web')->user()->id,
            'commentable_id' => $commentId,
            'commentable_type' => $commentableType
         ]);
         broadcast(new CommentEvent($this->comment))->toOthers(); 

    }

    public function render()
    {
        return view('livewire.blog.comment', [
            'comment' => $this->comment,
            'isLiked' => $this->comment->likes()->where('user_id', auth()->id())->exists()
    ]);
    }

    public function getListeners()
    {
        return [
            "echo-private:comment-channel.{$this->comment->id},CommentEvent" => 'refreshComments',
            'refreshSingleComment' => 'refreshComment', 

        ];
    }
    
    public function refreshComments($eventData)
    {
        $this->comment = ModelsComment::with('replies')->find($this->comment->id);
    }


    public function refreshComment($commentId)
    {
        // Refresh the comment only if the event matches this comment's ID
        if ($this->comment->id == $commentId) {
            $this->comment = $this->comment->fresh(); // Reload the comment from the database
        }
    }
}
