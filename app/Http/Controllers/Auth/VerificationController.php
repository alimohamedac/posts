<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyRequest;
use App\Models\User;

class VerificationController extends Controller
{
    public function verify(VerifyRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['message' => trans('messages.user_not_found')], 404);
        }

        if ($user->verification_code === $request->verification_code) {
            $user->is_verified = true;
            $user->verification_code = null; // Clear the code after verification
            $user->save();

            return response()->json(['message' => trans('messages.user_verified')], 200);
        } else {
            return response()->json(['message' => trans('messages.user_not_verified')], 400);
        }
    }
}
