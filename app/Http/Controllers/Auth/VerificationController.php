<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'verification_code' => 'required|string|size:6',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->verification_code === $request->verification_code) {
            $user->is_verified = true;
            $user->verification_code = null; // Clear the code after verification
            $user->save();

            return response()->json(['message' => 'Account verified successfully.'], 200);
        } else {
            return response()->json(['message' => 'Invalid verification code.'], 400);
        }
    }
}
