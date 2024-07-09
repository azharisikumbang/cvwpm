<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileTest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function edit()
    {
        return view('user.edit');
    }

    public function update(UpdateUserProfileTest $request)
    {
        $request->user()->update($request->validated());

        return redirect()
            ->route('user.profile')
            ->with('success', 'Profil pengguna berhasil diperbaharui.')
        ;
    }
}
