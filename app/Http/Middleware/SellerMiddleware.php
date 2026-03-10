<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user || !$user->isSeller()) {
            if ($user && $user->isSuperAdmin()) {
                return redirect()->route('super-admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
