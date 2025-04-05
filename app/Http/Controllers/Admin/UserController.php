<?php

namespace App\Http\Controllers\Admin;

use App\Mail\VerificationMail;
use App\Models\user;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
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
        return view('admin.users', [
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
        return view('admin.create', [
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
