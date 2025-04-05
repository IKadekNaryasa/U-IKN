<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $sanitize = [
            'username' => e(trim($request->input('username'))),
            'password' => e(trim($request->input('password')))
        ];

        $credential = Validator::make($sanitize, [
            'username' => ['required', 'string', 'min:6'],
            'password' => ['required', 'min:8']
        ])->validate();

        $verified = User::where('username', $credential['username'])->first();
        if ($verified->email_verified_at === null) {
            return redirect()->route('auth.index')->with('error', 'Your email not verified!')->withInput();
        }

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $verified->update(['logged_in' => true]);

            if (!$user) {
                Auth::logout();
                return redirect()->route('auth.index')->with('error', 'Authentication Failed!')->withInput();
            }

            if ($verified->password_updated_at === null) {
                return redirect()->route('auth.changePasswordView')->with('success', 'Login success! Change password first to keep safety!');
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Login success');
    }

    public function changePasswordView()
    {
        return view('auth.changePasswordFirsTime');
    }
    public function changePassword(Request $request)
    {
        return $request;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerate();
        return redirect()->route('auth.index')->with('success', 'logout success!');
    }
}
