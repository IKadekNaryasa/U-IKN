<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'active' => 'dashboard',
            'link' => 'Dashboard',
            'open' => '',
            'userCount' => User::where('status', 'active')->count()
        ]);
    }
}
