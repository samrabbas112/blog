<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $category = !is_null($id) ? Category::find($id) : null;
        return view('admin/categories/create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Category::where('id', $id)->delete();
        return response()->json(['success' => 'Category Deleted successfully!']);
    }
}
