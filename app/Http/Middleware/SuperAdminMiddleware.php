<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user || !$user->isSuperAdmin()) {
            if ($user && $user->isSeller()) {
                return redirect()->route('seller.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
