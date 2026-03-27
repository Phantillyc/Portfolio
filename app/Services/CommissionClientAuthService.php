<?php

namespace App\Services;

use App\Models\Commission\CommissionClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CommissionClientAuthService {
    public function guard() {
        return Auth::guard('commission_client');
    }

    public function user() {
        return $this->guard()->user();
    }

    public function check(): bool {
        return $this->guard()->check();
    }

    public function register(array $data): CommissionClient {
        $client = CommissionClient::create([
            'username'  => $data['username'],
            'password'  => Hash::make($data['password']),
            'is_active' => true,
        ]);

        return $client;
    }

    public function attemptLogin(string $username, string $password, bool $remember = false): bool {
        return $this->guard()->attempt([
            'username'  => $username,
            'password'  => $password,
            'is_active' => true,
        ], $remember);
    }

    public function login(CommissionClient $client, bool $remember = false): void {
        $this->guard()->login($client, $remember);
    }

    public function logout(Request $request): void {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
