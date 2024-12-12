<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; //Validator ekledik.
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', //Şifre doğrulama eklendi.
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); //Validation hataları için 422 döner.
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where('name', 'user')->first(); //user rolünü buluyoruz.
        $user->assignRole($role); //Kullanıcıya user rolünü atıyoruz.

        // $user->sendEmailVerificationNotification(); // Doğrulama e-postasını gönder

        return response()->json(['message' => 'Kayıt başarılı. E-posta adresinizi doğrulamanız gerekiyor.', 'user' => $user, 'redirect_url' => route('login')], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Geçersiz giriş bilgileri'], 401); // 401 Unauthorized
        }

        // if (!$user->hasVerifiedEmail()) { // e-posta doğrulamasını kontrol et. 
        //     return response()->json(['message' => 'E-posta adresiniz doğrulanmamış.'], 401);
        // }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Çıkış yapıldı'], 200);
    }
}