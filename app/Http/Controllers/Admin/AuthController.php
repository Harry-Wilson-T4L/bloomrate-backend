<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginFrom()
    {
        if (Auth::check()) {
            return redirect('admin/dashboard');
        }

        $title = 'Login';
        return view('admin.auth.login', compact('title'));
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'user_type' => 'admin'])) {
            return redirect('admin/dashboard')->with('success', 'Login success');
        } else {
            return back()->with('invalid', 'Invalid Credentials');
        }
    }

    public function logout()
    {   
        Auth::logout();
        return redirect('admin/login');
    }
}
