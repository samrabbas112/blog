<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('admin/tags/index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $tag = !is_null($id) ? Tag::find($id) : null;
        return view('admin/tags/create', compact('tag'));
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
            Tag::create([
                'name' => $validated['name']
            ]);
            return response()->json(['success' => 'Tag created successfully!']);
        } else {
            Tag::where('id', $id)->update([
                'name' => $validated['name']
            ]);
            return response()->json(['success' => 'Tag updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Tag::where('id', $id)->delete();
        return response()->json(['success' => 'Tag Deleted successfully!']);
    }
}
