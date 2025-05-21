<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Responses\ApiResponse;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $postsQuery = $this->postService->index();

        // Check if the request expects a DataTables response (useful for compatibility)
        if ($request->ajax()) {
            $dataTable = $this->postService->dataTableIndex();
            // Return the DataTables JSON response directly
            return response()->json($dataTable->getData());
        }

        // Fallback: return standard JSON response if not using DataTables
        $posts = PostResource::collection($postsQuery);

        return ApiResponse::sendResponse($posts, 'All Posts Fetched', 201);
    }


    /**
     * Store a newly created resource in storage.
     * @param PostRequest $request
     */
    public function store(PostRequest $request): JsonResponse
    {

        $user = auth('admin')->user();

        DB::beginTransaction();

        try {
            // Process uploaded files
            $filePath = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $filePath[] = $file->store('posts', 'public');
                }
            }

            // Prepare data for insertion
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'body' => $request->content,
                'excerpt' => $request->excerpt,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'featured_image' => !empty($filePath) ? json_encode($filePath) : null,
                'published_at' => $request->published_at ?? now(),
                'is_trending' => $request->flag === "trending",
                'is_featured' => $request->flag === "featured",
                'is_top' => $request->flag === "top",
                'admin_id' => $user->id,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords
            ];

            // Store the post using PostService
            $post = $this->postService->store($data);

            // Sync tags if present
            if ($request->tags) {
                $post->tags()->sync($request->tags);
            }

            DB::commit();

            // Use PostResource to format the response correctly
            return ApiResponse::sendResponse(new PostResource($post), 'Post created successfully', 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * @param PostRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PostRequest $request, int $id): JsonResponse
    {

        // Prepare data to be updated
        $data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->content,
            'excerpt' => $request->excerpt,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'published_at' => $request->published_at ?? now(),
            'is_trending' => $request->flag === "trending",
            'is_featured' => $request->flag === "featured",
            'is_top' => $request->flag === "top",
        ];

        DB::beginTransaction();

        try {

            // Update post via PostService
            $post = $this->postService->update($data, $id);

            // Sync tags if present
            if ($request->tags) {
                $post->tags()->sync($request->tags);
            }

            DB::commit();
            return ApiResponse::sendResponse(new PostResource($post), 'Post updated successfully', 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponse::rollback($ex);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Delete post via PostService
            $this->postService->delete($id);

            DB::commit();
            return ApiResponse::sendResponse(null, 'Post deleted successfully', 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponse::rollback($ex);
        }
    }

}
