<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function profile()
    {
        return view(
            'technician.profile',
            [
                'active' => 'profile',
                'open' => '',
                'link' => ' | Profile'
            ]
        );
    }
}
