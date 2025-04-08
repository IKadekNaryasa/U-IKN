<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view(
            'head.dashboard',
            [
                'active' => 'dashboard',
                'open' => '',
                'link' => 'Dashboard',
                'userCount' => User::where('status', 'active')->count(),
            ]
        );
    }

    public function users()
    {
        return view('head.users', [
            'active' => 'users',
            'link' => 'Users |',
            'open' => '',
            'users' => User::orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function profile()
    {
        return view('head.profile', [
            'active' => '',
            'link' => 'Profile',
            'open' => ''
        ]);
    }
}
