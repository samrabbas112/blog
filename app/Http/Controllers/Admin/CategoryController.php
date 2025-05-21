<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $user = auth()->guard('admin')->user();

        $data = Category::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) use($user) {
                    if(!$user->can('edit category')) {
                        $actionBtn = '<a href="' . route('category.destroy', ['id' => $row->id]) . '" class="delete-category btn btn-danger btn-sm">Delete</a>';
                    } elseif(!$user->can('delete category')) {
                        $actionBtn = '<a href="' . route('category.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>';
                    } else {
                        $actionBtn = '<a href="' . route('category.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="' . route('category.destroy', ['id' => $row->id]) . '" class="delete-category btn btn-danger btn-sm">Delete</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action']) // Mark 'avatar' as raw HTML to allow the image
                ->make(true);
        }
        return view('admin/categories/index', compact('data'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create($id = null)
    {
        $category = !is_null($id) ? Category::find($id) : null;
        return view('admin/categories/create',compact('category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tags'
        ]);
        $id = $request->input('id');
        if ($id == null) {
            Category::create([
                'name' => $validated['name']
            ]);
            return response()->json(['success' => 'Category created successfully!']);
        } else {
            Category::where('id', $id)->update([
                'name' => $validated['name']
            ]);
            return response()->json(['success' => 'Category updated successfully!']);
        }
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        Category::where('id', $id)->delete();
        return response()->json(['success' => 'Category Deleted successfully!']);
    }
}
