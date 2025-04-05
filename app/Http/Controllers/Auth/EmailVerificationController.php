<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    public function verify($id)
    {
        $user = User::find($id);


        if ($user->hasVerifiedEmail()) {
            return view('emails.verified');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $user->status = 'active';
            $user->save();
            event(new Verified($user));
        }

        return view('emails.verification_success');
    }
}
