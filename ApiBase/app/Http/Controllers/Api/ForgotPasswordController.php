<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.'], 200);
        } else {
            return response()->json(['message' => 'E-posta adresi bulunamadı.'], 404);
        }
    }
}
