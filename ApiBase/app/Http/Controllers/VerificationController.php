<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request): JsonResponse
    {
        $user = User::find($request->route('id'));
        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email has already been verified."], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(["message" => "Email successfully verified."], 200);
    }

    public function resend(Request $request)
    {

        $request->user()->sendEmailVerificationNotification();
        return response()->json(["message" => "Verification link sent on your email id"], 200);
    }
}
