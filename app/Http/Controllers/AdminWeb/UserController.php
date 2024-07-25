<?php

namespace App\Http\Controllers\AdminWeb;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\Role;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role', 'staf'])
            ->when(request('search'), function ($query) {
                $query->where('username', 'like', '%' . request('search') . '%');
            })
            ->when(request('page'), function ($query) {
                $query->offset((request('page') - 1) * 10);
            })
            ->orderBy('username')->paginate(request('per_page', 10));

        return view('admin-web.users.index', ['users' => $users->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all()->toArray();
        $staf = Staf::whereNull('user_id')->get()->toArray();

        return view('admin-web.users.create', [
            'roles' => $roles,
            'staf' => $staf
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $staf = Staf::find($request->staf);
        $role = Role::tryFromName($staf->jabatan);

        if (!$staf || !$role)
            return redirect()->route('admin-web.users.create')->with('error', 'Staf tidak ditemukan.');

        $user = User::create(
            $request->validated() + [
                'role_id' => $role->id
            ]
        );

        $staf->update(['user_id' => $user->id]);

        return redirect()->route('admin-web.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
