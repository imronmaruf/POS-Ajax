<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        // Cek role user
        $user = Auth::user();
        if ($user->role !== $role) {
            // Redirect atau abort jika user tidak memiliki role yang diperlukan
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
