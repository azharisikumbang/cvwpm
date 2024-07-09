<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('user.password');
    }

    public function update(UpdateUserPasswordRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('user.password.index')
            ->with('success', 'Password pengguna berhasil diperbaharui.');
    }
}
