<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->guard('admin')->user();

        $data = Tag::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) use($user) {
                    if(!$user->can('edit tags')) {
                        $actionBtn = '<a href="' . route('tags.destroy', ['id' => $row->id]) . '" class="delete-tag btn btn-danger btn-sm">Delete</a>';
                    } elseif(!$user->can('delete tags')) {
                        $actionBtn = '<a href="' . route('tags.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>';
                    } else {
                        $actionBtn = '<a href="' . route('tags.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="' . route('tags.destroy', ['id' => $row->id]) . '" class="delete-tag btn btn-danger btn-sm">Delete</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action']) // Mark 'avatar' as raw HTML to allow the image
                ->make(true);
        }
        return view('admin/tags/index', compact('data'));
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
