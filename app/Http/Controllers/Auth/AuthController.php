<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        if (!$verified) {
            return redirect()->route('auth.index')->with('error', 'invalid username or password!')->withInput();
        }
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

        $routes = [
            'admin' => 'admin.users.index',
            'technician' => 'technician.profile',
            'head' => 'head.dashboard.index'
        ];

        $role = $user->role;

        if (array_key_exists($role, $routes)) {
            return redirect()->route($routes[$role])->with('success', 'Login success!');
        }

        abort(404);
    }

    public function changePasswordView()
    {
        return view('auth.changePasswordFirsTime');
    }
    public function changePassword(Request $request)
    {
        if ($request->input('oldPassword')) {
            $sanitize = [
                'oldPassword' => e(trim($request->input('oldPassword'))),
                'newPassword' => e(trim($request->input('newPassword'))),
                'confirmNewPassword' => e(trim($request->input('confirmNewPassword')))
            ];

            $credential = Validator::make($sanitize, [
                'oldPassword' => ['required', 'min:8'],
                'newPassword' => ['required', 'min:8'],
                'confirmNewPassword' => ['required', 'min:8', 'same:newPassword']
            ]);
            if ($credential->fails()) {
                return redirect()->back()->withErrors($credential)->with('errorFrom', 'changePassword');
            };
            $validatedData = $credential->validate();

            if (!Hash::check($validatedData['oldPassword'], Auth::user()->getAuthPassword())) {
                return redirect()->back()->withErrors(['error' => 'invalid old Password'])->with('errorFrom', 'changePassword');
            }
            $data = [
                'password' => Hash::make($validatedData['newPassword']),
                'password_updated_at' => now()
            ];

            DB::transaction(function () use ($data) {
                $user = User::find(Auth::user()->id);
                $user->update($data);
            });

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.index')->with('success', 'password updated! login again!');
        }

        $sanitize = [
            'newPassword' => e(trim($request->input('newPassword'))),
            'confirmNewPassword' => e(trim($request->input('confirmNewPassword')))
        ];

        $credential = Validator::make($sanitize, [
            'newPassword' => ['required', 'min:8'],
            'confirmNewPassword' => ['required', 'min:8', 'same:newPassword']
        ]);
        if ($credential->fails()) {
            return redirect()->back()->withErrors($credential);
        };
        $validatedData = $credential->validate();
        $data = [
            'password' => Hash::make($validatedData['newPassword']),
            'password_updated_at' => now()
        ];

        DB::transaction(function () use ($data) {
            $user = User::find(Auth::user()->id);
            $user->update($data);
        });

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.index')->with('success', 'password updated! Login again!');
    }

    public function logout()
    {
        DB::transaction(function () {
            $user = User::find(Auth::user()->id);
            $user->update(['logged_in' => false]);
            Auth::logout();
            session()->invalidate();
            session()->regenerate();
        });
        return redirect()->route('auth.index')->with('success', 'logout success!');
    }

    public function update(Request $request, user $user)
    {
        $sanitize = [
            'name' => e(trim($request->input('name'))),
            'username' => e(trim($request->input('username'))),
            'contact' => e(trim($request->input('contact'))),
            'email' => e(trim($request->input('email'))),
            'role' => e(trim($request->input('role'))),
        ];

        $credential = Validator::make($sanitize, [
            'name' => ['required', Rule::unique('users', 'name')->ignore($user->id)],
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
            'contact' => ['required', Rule::unique('users', 'contact')->ignore($user->id)],
            'email' => ['required', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required'],
        ])->validate();

        if ($user->username != $credential['username'] || $user->email != $credential['email']) {
            DB::transaction(function () use ($user, $credential) {
                $password = Str::random(10);
                $user->update([
                    'name' => $credential['name'],
                    'username' => $credential['username'],
                    'password' => $password,
                    'password_updated_at' => null,
                    'email_verified_at' => null,
                    'contact' => $credential['contact'],
                    'email' => $credential['email'],
                    'status' => 'waiting_verification',
                    'role' => $credential['role']
                ]);
                $verficationUrl = URL::signedRoute('verification.verify', [
                    'id' => $user->id,
                    'hash' => sha1($user->email)
                ]);

                Mail::to($user->email)->send(new VerificationMail(
                    $user->username,
                    $password,
                    $user->name,
                    $verficationUrl
                ));
            });

            if ($user->id === Auth::user()->id) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                session()->regenerate();
                return redirect()->route('auth.index')->with('success', "You're Data updated! check email to verification you're email!");
            }

            session()->regenerate();
            return redirect()->route('admin.users.index')->with('success', 'Data updated! check the email to confirm updated data!');
        }

        DB::transaction(function () use ($user, $credential) {
            $user->update([
                'name' => $credential['name'],
                'contact' => $credential['contact'],
                'role' => $credential['role']
            ]);
        });

        if ($user->id === Auth::user()->id) {
            if ($request->input('regenerate') !== "false") {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                session()->regenerate();
                return redirect()->route('auth.index')->with('success', "You're Data updated!");
            }
            session()->regenerate();
            return redirect()->back()->with('success', "You're Data updated!");
        }
        session()->regenerate();
        return redirect()->route('admin.users.index')->with('success', 'Data updated!');
    }
}
