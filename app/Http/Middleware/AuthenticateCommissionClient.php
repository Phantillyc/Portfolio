<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCommissionClient {
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response {
        if (!auth('commission_client')->check()) {
            return redirect()->to('commissions/account/login?redirect='.urlencode($request->fullUrl()));
        }

        return $next($request);
    }
}
