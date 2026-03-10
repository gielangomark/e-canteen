<?php

namespace App\Providers;

use App\Models\BalanceRequest;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $pendingOrderCount = 0;
            $pendingBalanceCount = 0;
            $pendingWithdrawalCount = 0;

            if (Auth::check()) {
                $user = Auth::user();

                if ($user->isSuperAdmin()) {
                    $pendingBalanceCount = BalanceRequest::where('status', 'pending')->count();
                    $pendingWithdrawalCount = Withdrawal::where('status', 'pending')->count();
                } elseif ($user->isSeller() && $user->canteen) {
                    $pendingOrderCount = Order::where('canteen_id', $user->canteen->id)
                        ->whereIn('status', ['pending', 'preparing', 'ready'])
                        ->count();
                }
            }

            $view->with(compact('pendingOrderCount', 'pendingBalanceCount', 'pendingWithdrawalCount'));
        });
    }
}
