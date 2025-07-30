<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function loginPost(Request $requestLogin)
    {
        $requestLogin->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $loginField = $requestLogin->input('identifier');
        $password = $requestLogin->input('password');

        $user = User::where('username', $loginField)
                    ->orWhere('email', $loginField)
                    ->first();

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => "Couldn't find your Attendance Account",
                'epRow' => true,
                'pRow' => true,
            ]);
        }

        if (!Auth::attempt(['email' => $user->email, 'password' => $password])) {
            return response()->json([
                'error' => true,
                'message' => 'Incorrect password',
                'pRow' => true,
            ]);
        }

        $requestLogin->session()->regenerate();

        return $requestLogin->expectsJson()
            ? response()->json(['redirect' => route('dashboard')])
            : redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function contentStudent($page)
    {   
        if (!in_array($page, ['home', 'scan', 'attendance'])) {
            abort(404);
        }

        return view("student.$page");
    }

    public function contentTeacher($page)
    {
        if (!in_array($page, ['home', 'attendanceqrcode', 'attendance'])) {
            abort(404);
        }

        return view("teacher.$page");
    }
}
