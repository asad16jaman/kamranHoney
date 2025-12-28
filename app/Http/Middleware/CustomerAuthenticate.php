<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated. Please login first.',
                    'login_url' => route('customer.login'),
                ], 401);
            }

            return redirect()->route('customer.login');
        }

        return $next($request);
    }

}
