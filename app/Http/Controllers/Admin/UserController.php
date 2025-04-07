<?php

namespace App\Http\Controllers\Admin;

use App\Models\user;
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
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.users', [
            'active' => 'users',
            'link' => 'IKN Project | Users',
            'open' => 'view_users',
            'users' => User::orderBy('name', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create', [
            'active' => 'users',
            'link' => 'IKN Project | Users',
            'open' => 'create_user',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sanitize = [
            'name' => e(ucwords(strtolower($request->input('name')))),
            'username' => e($request->input('username')),
            'contact' => e($request->input('contact')),
            'email' => e($request->input('email')),
            'role' => e($request->input('role'))
        ];

        $credential = Validator::make($sanitize, [
            'name' => ['required', 'string', 'unique:users,name'],
            'username' => ['required', 'string', 'unique:users,username'],
            'contact' => ['required', 'string', 'unique:users,contact'],
            'email' => ['required', 'string', 'unique:users,email'],
            'role' => ['required', 'string', 'in:head,admin,technician']
        ])->validate();

        $password = Str::random(10);
        $data = [
            'name' => $credential['name'],
            'email' => $credential['email'],
            'username' => $credential['username'],
            'password' => Hash::make($password),
            'contact' => $credential['contact'],
            'role' => $credential['role'],
        ];

        DB::transaction(function () use ($data, $password) {
            $user =  User::create($data);
            $verificationUrl = URL::signedRoute(
                'verification.verify',
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            Mail::to($user->email)->send(new VerificationMail(
                $user->username,
                $password,
                $user->name,
                $verificationUrl
            ));
        });

        return redirect()->route('admin.users.index')->with('success', 'Success, user created! check the email for acount verification!');
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        return view('admin.users.edit', [
            'active' => 'users',
            'open' => '',
            'link' => "Users | Edit | $user->name",
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        if ($user->id === Auth::user()->id) {
            return redirect()->back()->withErrors(['error' => 'Can not delete data because this acount still login in your browser!']);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Acount deleted!');
    }

    public function profile()
    {
        return view('admin.profile', [
            'active' => '',
            'open' => '',
            'link' => 'Profile',
        ]);
    }
}
