<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user || !$user->isUser()) {
            if ($user && $user->isSuperAdmin()) {
                return redirect()->route('super-admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            if ($user && $user->isSeller()) {
                return redirect()->route('seller.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
