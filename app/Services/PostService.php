<?php

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Yajra\DataTables\Facades\DataTables;

class PostService
{
   public function __construct(protected PostRepositoryInterface $postRepository)
   {

   }

   public function store(array $data): Post
   {
       return $this->postRepository->store($data);
   }

    public function update(array $data, $id)
    {
        return $this->postRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    public function index()
    {
        $user = auth('admin')->user();
        $posts = $this->postRepository->index();
        if($user->can('view all posts')) {
         return $posts;
        } else {
            return $posts->where('admin_id', $user->id);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function  dataTableIndex()
    {
        $user = auth('admin')->user();

        $data = $this->index();
        return DataTables::of($data)
            ->addColumn('category', function ($post) use($user) {
                return optional($post->categories)->name ?? 'N/A';
            })
            ->addColumn('author', function ($post) {
                return optional($post->admins)->name ?? 'N/A';
            })
            ->addColumn('action', function ($post) use($user) {
                $editUrl = route('posts.create', ['id' => $post->id]);
                $deleteUrl = route('api.v1.posts.destroy', [$post->id]);
                if(!$user->can('edit posts')){
                    return '<a href="#" data-id="'.$post->id .'"class="delete-post btn btn-danger btn-sm">Delete</a>';

                }
                else if(!$user->can('delete posts')) {
                    return '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';

                } else {
                    return '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>
                        <a href="#" data-id="'.$post->id .'"class="delete-post btn btn-danger btn-sm">Delete</a>';

                }

            })
            ->rawColumns(['action']) // Allow HTML rendering in the 'action' column
            ->make(true);
    }
}
