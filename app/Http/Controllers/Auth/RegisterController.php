<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'verification_code' => Str::random(6),
            'is_verified' => false,
        ]);

        Log::info('Verification code for ' . $user->phone_number . ' is: ' . $user->verification_code);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => trans('messages.user_registered')
        ], 201);
    }
}
