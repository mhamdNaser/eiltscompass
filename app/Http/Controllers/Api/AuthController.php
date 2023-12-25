<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Mail\MyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        // $activationToken = Str::random(60);

        /** @var \App\Models\User $user */
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'country' => $data['country'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout(); // Log out the user since they don't have active status
            return response([
                'message' => 'User account is not active'
            ], 422);
        }

        $token = $user->createToken('main')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Login Successfully',
            'token' => $token,
            'admin' => $user, // Include admin details in the response
        ]);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user(); // Get the authenticated user

        if (!$user) {
            // Handle the case where no authenticated user is found (e.g., unauthorized access)
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if the user has an active token and delete it
        if ($user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        } else {
            // Handle the case where no current access token is found for the user
            return response()->json(['error' => 'No access token found'], 404);
        }

        // Return a success response with status code 204 (No Content)
        return response('', 204);
    }
}