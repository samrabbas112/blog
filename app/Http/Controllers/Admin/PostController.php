<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\Author;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->guard('admin')->user();

        // Check if the user has permission to view all posts
        if ($user->can('view all posts')) {
            // If the user has permission, fetch all posts
            $posts = Post::with('categories','admins')->get();
        } else {
            // If the user does not have permission, fetch only the user's posts
            $posts = Post::with('categories','admins')->where('admin_id', $user->id)->get();
        }
        if ($request->ajax()) {
            return DataTables::of($posts)
                ->addColumn('category', function ($row) {
                    // Show the category name (assuming categories relation is properly set)
                    return $row->categories->name;
                })
                ->addColumn('author', function ($row) {
                    // Get the author's name (assuming author relation is properly set)
                    return $row->admins->name;
                })
                ->addColumn('action', function ($row) use($user) {
                    // Edit and Delete buttons for actions
                    $editUrl = route('posts.create', ['id' => $row->id]);
                    $deleteUrl = route('posts.destroy', ['id' => $row->id]);
                    if(!$user->can('edit posts')){
                        return '<a href="#" data-id="'.$row->id .'"class="delete-post btn btn-danger btn-sm">Delete</a>';

                    }
                    else if(!$user->can('delete posts')) {
                        return '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';

                    } else {
                        return '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>
                        <a href="#" data-id="'.$row->id .'"class="delete-post btn btn-danger btn-sm">Delete</a>';

                    }
                })
                ->rawColumns(['action']) // Mark these columns as raw HTML to allow rendering
                ->make(true);
    
        }
        

        return view('admin/posts/index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $post = !is_null($id) ? Post::find($id) : null;
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin/posts/create',compact('post','categories','tags'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $user = Auth::guard('admin')->user();
    // Validate the request data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug,' . $request->input('id'),
        'content' => 'required|string',
        'excerpt' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'tags' => 'array',
        'tags.*' => 'exists:tags,id', // Validate each tag ID exists
        'status' => 'required|in:published,draft,archived',
        'published_at' => 'nullable|date',
        'meta_description' => 'nullable|string|max:160',
        'meta_keywords' => 'nullable|string|max:255',
        'flag' => 'required|in:trending,top,featured',
        'file.*' => 'file|mimetypes:image/jpeg,image/png,image/jpg|max:2048', // Example for image file
    ]);
    
    $id = $request->input('id'); // Get the ID from the request

    $filePath = [];
    if ($request->hasFile('file')) {
        foreach($request->file('file') as $file) {
            $filePath[] = $file->store('posts', 'public'); // Store in 'public/posts' directory
        }
    }
    
    // Create or update the post
    if ($id == null) {
       
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => $validated['content'],
            'excerpt' => $validated['excerpt'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'featured_image' => json_encode($filePath) ?? null,
            'published_at' => $validated['published_at'] ? $validated['published_at'] : now(),
            'is_trending' => $validated['flag'] == "trending" ? true : false,
            'is_featured' => $validated['flag'] == "featured" ? true : false,
            'is_top' => $validated['flag'] == "top" ? true : false,
            'admin_id' => $user->id, 
            // Other fields as necessary
        ]);
        

        // Sync tags (Many to Many relationship)
        if ($validated['tags']) {
            $post->tags()->sync($validated['tags']); // Sync tags with the post
        }

        return response()->json(['success' => 'Post created successfully!']);
    } else {
        // Update the existing post
        $post = Post::findOrFail($id);
        // dump($filePath);
        // dd($validated);
        $post->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => $validated['content'],
            'excerpt' => $validated['excerpt'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'featured_image' => !empty($filePath) ? json_encode($filePath) : $post->featured_image, // Keep existing if no new file
            'published_at' => $validated['published_at'] ? $validated['published_at'] : $post->published_at,
            'is_trending' => $validated['flag'] == "trending" ? true : false,
            'is_featured' => $validated['flag'] == "featured" ? true : false,
            'is_top' => $validated['flag'] == "top" ? true : false,
        ]);

        // Sync tags (Many to Many relationship)
        if ($validated['tags']) {
            $post->tags()->sync($validated['tags']); // Sync tags with the post
        }

        return response()->json(['success' => 'Post updated successfully!']);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Post::where('id',$id)->delete();
        return response()->json(['success' => 'Post deleted successfully']);

    }
}
