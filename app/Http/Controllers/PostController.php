<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        dd('kkk');
        $user = auth()->user();

        // Check if the user has permission to view all posts
        if ($user->can('view-all-posts')) {
            // If the user has permission, fetch all posts
            $data = Post::with('categories')->get();
        } else {
            // If the user does not have permission, fetch only the user's posts
            $data = Post::with('categories')->where('author_id', $user->id)->get();
        }
        dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('avatar', function ($row) {
                    return '<img src="' . asset('storage/'.$row->avatar) . '" alt="Avatar" width="50" height="50" style="border-radius: 50%;" />';
                })
                ->addColumn('roles', function ($row) {
                    return $row->roles->pluck('name')->implode(', '); // Get all role names as a comma-separated string
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('users.create', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="' . route('users.destroy', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                          return $actionBtn;
                })
                ->rawColumns(['avatar', 'action']) // Mark 'avatar' as raw HTML to allow the image
                ->make(true);
        }
        
        

        return view('posts/index',compact('posts','tags','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $post = !is_null($id) ? Post::find($id) : null;
        $tags = Tag::all();
        $categories = Category::all();
        return view('posts/create',compact('post','categories','tags'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'content' => 'required|string',
            'excerpt' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id', // Validate each tag ID exists
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'file.*' => 'nullable|file|mimetypes:image/jpeg,image/png,image/jpg|max:2048', // Example for image file
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Return error response
        }

        // Save the post
        $post = new Post();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->content;
        $post->excerpt = $request->excerpt;
        $post->category_id = $request->category_id;
        $post->status = $request->status;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        $request->flag == 'top' ? ($post->is_top == true) : ($request->flag == 'featured' ? ($post->is_featured == true) : $post->is_trending == true);
        

        // Handle the uploaded file if present
        if ($request->hasFile('file')) {
            foreach($request->file('file') as $file) {
                $filePath[] = $file->store('posts', 'public'); 
    
        }
        }
        $post->author_id = Auth::user()->id;
        $post->featured_image = json_encode($filePath);
        $post->published_at = $request->published_at ? $request->published_at : now();
        $post->save();

        // Sync tags (Many to Many relationship)
        if ($request->tags) {
            $post->tags()->sync($request->tags); // Sync tags with the post
        }

        return response()->json(['success' => 'Post created successfully!']);
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
