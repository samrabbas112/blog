<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @return Collection<int, Post>
     */
    public function  index(): Collection
    {
        return Post::with(['categories','tags'])->get();
    }

    /**
     * @param int $id
     * @return Post
     */
    public  function  show(int $id): Post
    {
        return  Post::findOrFail($id);
    }

    /**
     * @param array $data
     * @return Post
     */
    public  function  store(array $data): Post
    {

        $post = Post::create($data);

        $post->load('categories');
        $post->load('tags');// Eager load the category relationship

        return $post;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Post
     */
    public function update(array $data, int $id): Post
    {
        Post::whereId($id)->update($data);
        // Retrieve and return the updated post instance
        return Post::findOrFail($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Post::destroy($id);
    }

}
