<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * GET /v1/auth/csrf-cookie
     * Wajib dipanggil dari frontend sebelum POST login/register agar browser
     * menyimpan XSRF-TOKEN cookie. Sanctum otomatis menyediakan endpoint bawaan
     * /sanctum/csrf-cookie, tapi kita bungkus agar konsisten prefix /v1.
     */
    public function csrf(Request $request)
    {
        // Forward ke endpoint sanctum bawaan
        // Cara termudah: cuma balikan OK; pastikan middleware web aktif
        // dan front-end hit GET /sanctum/csrf-cookie langsung juga boleh.
        return response()->json(['ok' => true]);
    }

    /**
     * POST /v1/auth/register
     * Body: { name, email, password, password_confirmation }
     * Akses: publik
     * Efek: membuat user baru; (opsi) langsung login setelah register.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:100'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // otomatis di-hash oleh cast di model User
        ]);

        // (Opsional) login langsung setelah register:
        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Registered & logged in',
            'user'    => $user,
        ], 201);
    }

    /**
     * POST /v1/auth/login
     * Body: { email, password }
     * Akses: publik
     * Efek: membuat session cookie jika kredensial benar.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        // Auth::attempt pakai guard 'web' (session)
        if (! Auth::attempt($credentials, true)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        // regenerate session ID untuk keamanan
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in',
            'user'    => $request->user(),
        ]);
    }

    /**
     * POST /v1/auth/logout
     * Akses: login (auth:sanctum)
     * Efek: hapus session, rotate CSRF token.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * GET /v1/auth/me
     * Akses: login (auth:sanctum)
     * Efek: kembalikan data user yang sedang login.
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
