<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $auth;

    public function __construct(AuthService $authService)
    {
        $this->auth = $authService;
    }

    // ==============================
    // REGISTER
    // ==============================
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Pastikan email unik di database yang aktif
        if ($this->auth->findByEmail($validated['email'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email ini sudah terdaftar. Silakan login atau gunakan email lain.'
            ], 422);
        }

        $token = $this->auth->register($validated);

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'message' => 'Registrasi berhasil!'
        ], 201);
    }

    // ==============================
    // LOGIN
    // ==============================
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $token = $this->auth->login($validated['email'], $validated['password']);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'message' => 'Login berhasil'
        ]);
    }

    // ==============================
    // LOGOUT
    // ==============================
    public function logout()
    {
        $this->auth->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout'
        ]);
    }

    // ==============================
    // REFRESH TOKEN
    // ==============================
    public function refresh()
    {
        $token = $this->auth->refresh();

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'token' => $token
        ]);
    }

    // ==============================
    // GET AUTHENTICATED USER (ME)
    // ==============================
    public function me()
    {
        $user = $this->auth->me();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    // ==============================
    // UPDATE PROFILE
    // ==============================
    public function updateProfile(Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name'     => 'nullable|string|min:3',
            'email'    => 'nullable|email',
            'password' => 'nullable|string|min:6'
        ]);

        $updated = $this->auth->updateProfile($userId, array_filter($validated));

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil diperbarui',
            'user'    => $updated
        ]);
    }

    // ==============================
    // CHANGE PASSWORD
    // ==============================
    public function changePassword(Request $request)
    {
        $userId = $this->auth->id();
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        $result = $this->auth->changePassword(
            $userId,
            $request->input('current_password'),
            $request->input('new_password')
        );

        if (!$result['success']) {
            return response()->json([
                'status'  => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => $result['message']
        ]);
    }
}
