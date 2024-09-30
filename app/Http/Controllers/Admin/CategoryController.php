<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin/categories/index',compact('categories'));
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
