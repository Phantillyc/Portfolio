<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionAuth\LoginCommissionClientRequest;
use App\Http\Requests\CommissionAuth\RegisterCommissionClientRequest;
use App\Services\CommissionClientAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommissionAuthController extends Controller {
    public function __construct(private CommissionClientAuthService $authService) {
    }

    public function getLogin(Request $request) {
        return view('commissions.auth.login', [
            'redirect' => $request->get('redirect'),
            'client'   => $this->authService->user(),
        ]);
    }

    public function getSignup(Request $request) {
        return view('commissions.auth.signup', [
            'redirect' => $request->get('redirect'),
            'client'   => $this->authService->user(),
        ]);
    }

    public function postRegister(RegisterCommissionClientRequest $request): RedirectResponse {
        $data = $request->validated();

        $client = $this->authService->register($data);
        $this->authService->login($client, true);
        $request->session()->regenerate();

        flash('Account created and signed in.')->success();

        return redirect()->to($this->safeRedirect($request->input('redirect')) ?: url('/'));
    }

    public function postLogin(LoginCommissionClientRequest $request): RedirectResponse {
        $data = $request->validated();
        $remember = (bool) ($data['keep_me_signed_in'] ?? false);

        if (!$this->authService->attemptLogin($data['username'], $data['password'], $remember)) {
            flash('Invalid username or password, or account is inactive.')->error();

            return redirect()->back()->withInput($request->except('password'));
        }

        $request->session()->regenerate();
        flash('Signed in.')->success();

        return redirect()->to($this->safeRedirect($data['redirect'] ?? null) ?: url('/'));
    }

    public function postLogout(Request $request): RedirectResponse {
        $this->authService->logout($request);
        flash('Signed out.')->success();

        return redirect()->to('commission-auth/login');
    }

    private function safeRedirect(?string $url): ?string {
        if (!$url) {
            return null;
        }

        if (str_starts_with($url, '/')) {
            return $url;
        }

        if (str_starts_with($url, config('app.url'))) {
            return $url;
        }

        return null;
    }
}
