<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = Http::post(env('API_URL') . '/register', $request->all()); // API'ye istek gönder

        if ($response->successful()) {
            // Başarılı kayıt
            if ($response->json() && isset($response->json()["message"]))
                return redirect()->route('login')->with('success', $response->json()["message"]);
            else
                return redirect()->route('login')->with('success', 'Kayıt başarılı. Lütfen e-posta adresinizi doğrulayın2222.');
        } else {
            // Hata yönetimi
            if ($response->json() && isset($response->json()['errors'])) {
                $errors = $response->json()['errors'];
            } else {
                $errors = ['generic' => 'Bir hata oluştu. Lütfen tekrar deneyin.'];
            }
            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post(env('API_URL') . '/login', $request->only('email', 'password'));
        dd($response->json());
        if ($response->successful()) {
            $token = $response->json()['token'];
            $user = $response->json()['user'];
            session(['api_token' => $token, 'user' => $user]); //API token'ı sessionda saklanıyor.
            return redirect()->intended('/dashboard'); // Panel rotasına yönlendir
        } else {
            return redirect()->back()->withErrors(['message' => 'Geçersiz giriş bilgileri'])->withInput();
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        $token = session('api_token');

        if ($token) {
            Http::withToken($token)->post(env('API_URL') . '/logout');
        }
        $request->session()->flush(); // Session'ı temizle
        Auth::logout(); // Laravel Auth ile oturumu kapat
        return redirect('/login');
    }

    public function sendVerificationEmail(Request $request)
    {
        $response = Http::withToken(session('api_token'))->get(env('API_URL') . '/email/verify-resend');
        if ($response->successful()) {
            return back()->with('message', 'Doğrulama bağlantısı tekrar gönderildi.');
        }
        return back()->with('message', 'Doğrulama bağlantısı tekrar gönderilemedi.');
    }
}