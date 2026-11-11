<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // cek login
        if (Auth::check()) {

            // cek role admin/superadmin
            if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                return $next($request);
            }
        }

        // jika bukan admin
        return redirect()
            ->route('admin.login')
            ->with('error', 'Akses ditolak! Anda bukan admin.');
    }
}
