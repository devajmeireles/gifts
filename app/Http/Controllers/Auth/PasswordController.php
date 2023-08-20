<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit(): View
    {
        return view('password.edit');
    }

    public function update(PasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()
            ->update([
                'password' => Hash::make($request->validated()['password']),
            ]);

        return back()->with('status', 'password-updated');
    }
}
