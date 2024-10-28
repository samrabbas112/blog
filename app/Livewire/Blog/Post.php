<?php

namespace App\Livewire\Blog;

use App\Events\LikeEvent;
use App\Models\Category;
use App\Models\Post as ModelsPost;
use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Post extends Component
{
    use WithPagination;
    public $tags;
    public $categories;
    public $perPage = 2; // Number of posts per page
    public $selectedPostId = null;

    public function mount()
    {
        $this->tags = Tag::all();
        $this->categories = Category::all();
    }

    public function render()
    {
        $posts = ModelsPost::with('categories')->paginate($this->perPage);

        return view('livewire.blog.post', [
            'posts' => $posts, // Pass the posts property to the view
        ]);
    }

    public function updatingPerPage()
    {
        $this->resetPage(); // Reset the pagination when changing items per page
    }

    public function togglePostDetails($postId)
    {
      $this->selectedPostId = $postId;
    }

    public function likePost($postId)
    {
        $user = auth()->user();

        if ($user) {
            $post = ModelsPost::find($postId);
            broadcast(new LikeEvent($post))->toOthers();

           // Check if the user already liked the comment
        // $like = $post->likes()->where('user_id', $user->id)->first();

        // if ($like) {
        //     // Unlike the comment
        //     $like->delete(); // Delete the like entry
        //     $post->likes_count--;
        //     $post->save();
        // } else {
        //     // Like the comment
        //     $post->likes()->create(['user_id' => $user->id]); // Create a new like entry
        //     $post->likes_count++;
        //     $post->save();
        // }
        }
    }

   
}
