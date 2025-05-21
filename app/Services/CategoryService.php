<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class CategoryService
{
   public  function  __construct(protected CategoryRepositoryInterface $categoryRepository)
   {

   }

    public function store(array $data)
    {
        return $this->categoryRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->categoryRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function index()
    {
        return $this->categoryRepository->index();
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
            ->addColumn('action', function ($row) use($user) {
                if(!$user->can('edit category')) {
                    $actionBtn = '<a href="#" data-id="' . $row->id . '" class="delete-category btn btn-danger btn-sm">Delete</a>';
                } elseif(!$user->can('delete category')) {
                    $actionBtn = '<a href="' . route('category.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>';
                } else {
                    $actionBtn = '<a href="' . route('category.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="#" data-id="' . $row->id . '" class="delete-category btn btn-danger btn-sm">Delete</a>';
                }
                return $actionBtn;
            })
            ->rawColumns(['action']) // Mark 'avatar' as raw HTML to allow the image
            ->make(true);
    }
}
