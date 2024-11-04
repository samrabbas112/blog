<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Responses\ApiResponse;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $categories = $this->categoryService->index();

        // Check if the request expects a DataTables response (useful for compatibility)
        if ($request->ajax()) {
            $dataTable = $this->categoryService->dataTableIndex();

            // Return the DataTables JSON response directly
            return response()->json($dataTable->getData());
        }

        // Fallback: return standard JSON response if not using DataTables
        $tags = TagResource::collection($categories);

        return ApiResponse::sendResponse($tags, 'All Categories Fetched', 201);
    }


    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     */
    public function  store(CategoryRequest $request): JsonResponse
    {
        $data =[
            'name' => $request->name,
        ];
        DB::beginTransaction();
        try{
            $category = $this->categoryService->store($data);

            DB::commit();
            return ApiResponse::sendResponse(new CategoryResource($category),'Category Create Successfully',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    public function update(CategoryRequest $request, int $id): JsonResponse
    {
        $data =[
            'name' => $request->name,
        ];
        DB::beginTransaction();
        try{
            $category = $this->categoryService->update($data,$id);

            DB::commit();
            return ApiResponse::sendResponse(new CategoryResource($category),'Category Updated SuccessfulLy',201);

        }catch(\Exception $ex){
            return ApiResponse::rollback($ex);
        }
    }

    public function destroy(int $id): JsonResponse
    {

        $this->categoryService->delete($id);

        return ApiResponse::sendResponse('Category Deleted Successfully',201);

    }

}
