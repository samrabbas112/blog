<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $superAdminCount = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name','!==', 'Super-Admin')->toArray()
        );
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
        return view('users/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $user = !is_null($id) ? User::find($id) : null;
        return view('users/create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // dd($request->all());

    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|unique:users,name,' . $request->input('id'),
        'email' => 'required|email|unique:users,email,' . $request->input('id'),
        'password' => 'required|min:8', // Adjust the password rules as necessary
        'dob' => 'required|date',
        'file.*' => 'file|mimes:jpg,png,jpeg,pdf|max:2048',  // Add validation for the file types you expect
        'roles' => 'required|array',
        'roles.*' => 'string', // Each role should be a string
    ]);

    $id = $request->input('id');

    // Handle avatar upload if it exists
    if ($request->hasFile('file')) {
        foreach($request->file('file') as $file) {
            $avatarPath[] = $file->store('avatars', 'public'); // Store in 'public/avatars' directory

    }
    }
    // dd( $avatarPath);
    // Create or update the user
    if ($id == null) {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // Hash the password
            'dob' => $validated['dob'],
            'avatar' => json_encode($avatarPath) ?? null, // Store the path if avatar exists
        ]);
        foreach($validated['roles'] as $key=>$role) {
            $user->assignRole($key);
        }
        return response()->json(['success' => 'User created successfully!']);
    } else {
        User::where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dob' => $validated['dob'],
            'avatar' => json_encode($avatarPath) ?? null, // Update the avatar path if exists
        ]);

        return response()->json(['success' => 'User updated successfully!']);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        User::where('id', $id)->delete();
        return response()->json(['success' => 'Tag Deleted successfully!']);
    }
}
