<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Responses\ApiResponse;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $tagsQuery = $this->tagService->index();

        // Check if the request expects a DataTables response (useful for compatibility)
        if ($request->ajax()) {
            $dataTable = $this->tagService->dataTableIndex();
            // Return the DataTables JSON response directly
            return response()->json($dataTable->getData());
        }

        // Fallback: return standard JSON response if not using DataTables
        $tags = TagResource::collection($tagsQuery);

        return ApiResponse::sendResponse($tags, 'All Tags Fetched', 201);

    }


    /**
     * Store a newly created resource in storage.
     * @param TagRequest $request
     */
    public function  store(TagRequest $request): JsonResponse
    {

        $data =[
            'name' => $request->name,
        ];
        DB::beginTransaction();
        try{
            $tag = $this->tagService->store($data);

            DB::commit();
            return ApiResponse::sendResponse(new TagResource($tag),'Tag Create Successfully',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    public function update(TagRequest $request, int $id): JsonResponse
    {
        $data =[
            'name' => $request->name,
        ];
        DB::beginTransaction();
        try{
            $tag = $this->tagService->update($data,$id);

            DB::commit();
            return ApiResponse::sendResponse(new TagResource($tag),'Tag Updated SuccessfulLy',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $this->tagService->delete($id);

        return ApiResponse::sendResponse('Tag Deleted Successfully',201);

    }
}
