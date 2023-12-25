<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function activate($token)
{
    $user = User::where('activation_token', $token)->first();

    if (!$user) {
        abort(404); // Token not found
    }

    $user->update([
        'activation_token' => null,
        'is_activated' => true,
    ]);

    return redirect('/login')->with('message', 'Your account is now activated. You can log in.');
}
}
