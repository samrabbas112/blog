<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $superAdminCount = Admin::with('roles')->get()->filter(
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
        return view('admin/users/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = null)
    {
        $user = !is_null($id) ? Admin::find($id) : null;
        return view('users/create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|unique:admins,name,' . $request->input('id'),
        'email' => 'required|email|unique:admins,email,' . $request->input('id'),
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
    // Create or update the user
    if ($id == null) {
        $user = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // Hash the password
            'dob' => $validated['dob'],
            'avatar' => json_encode($avatarPath) ?? null, // Store the path if avatar exists
            'email_verified_at' => now()
        ]);
        
        foreach($validated['roles'] as $key => $role) {
            $user->assignRole(strtolower($key));
        }
        return response()->json(['success' => 'Admin created successfully!']);
    } else {
        Admin::where('id', $id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dob' => $validated['dob'],
            'avatar' => json_encode($avatarPath) ?? null, // Update the avatar path if exists
        ]);

        return response()->json(['success' => 'Admin updated successfully!']);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Admin::where('id', $id)->delete();
        return response()->json(['success' => 'Admin Deleted successfully!']);
    }
}

