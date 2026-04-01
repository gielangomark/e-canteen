<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\CanteenController;
use App\Http\Controllers\SuperAdmin\BalanceRequestController as SuperAdminBalanceRequestController;
use App\Http\Controllers\SuperAdmin\WithdrawalController as SuperAdminWithdrawalController;
use App\Http\Controllers\SuperAdmin\ReportController as SuperAdminReportController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\MenuController as SellerMenuController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\WithdrawalController as SellerWithdrawalController;
use App\Http\Controllers\Seller\ReportController as SellerReportController;
use App\Http\Controllers\User\BalanceRequestController as UserBalanceRequestController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\MenuController as UserMenuController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect /dashboard based on role
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();
    if ($user->isSuperAdmin()) {
        return redirect()->route('super-admin.dashboard');
    }
    if ($user->isSeller()) {
        return redirect()->route('seller.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Canteen Management
    Route::resource('canteens', CanteenController::class);

    // Balance Requests
    Route::get('/balance-requests', [SuperAdminBalanceRequestController::class, 'index'])->name('balance-requests.index');
    Route::patch('/balance-requests/{balanceRequest}/approve', [SuperAdminBalanceRequestController::class, 'approve'])->name('balance-requests.approve');
    Route::patch('/balance-requests/{balanceRequest}/reject', [SuperAdminBalanceRequestController::class, 'reject'])->name('balance-requests.reject');

    // Withdrawals
    Route::get('/withdrawals', [SuperAdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::patch('/withdrawals/{withdrawal}/approve', [SuperAdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::patch('/withdrawals/{withdrawal}/reject', [SuperAdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');

    // Reports
    Route::get('/reports', [SuperAdminReportController::class, 'index'])->name('reports.index');

    // User Management
    Route::resource('users', SuperAdminUserController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

    // Menu Management
    Route::resource('menus', SellerMenuController::class)->except(['show']);
    Route::patch('/menus/{menu}/toggle', [SellerMenuController::class, 'toggleAvailability'])->name('menus.toggle');

    // Order Management
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Withdrawals
    Route::get('/withdrawals', [SellerWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [SellerWithdrawalController::class, 'store'])->name('withdrawals.store');

    // Reports
    Route::get('/reports', [SellerReportController::class, 'index'])->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'user'])->name('user.')->group(function () {
    Route::get('/home', [UserDashboardController::class, 'index'])->name('dashboard');

    // Browse Canteens & Menus
    Route::get('/menu', [UserMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/search', [UserMenuController::class, 'search'])->name('menu.search');
    Route::get('/menu/canteen/{canteen}', [UserMenuController::class, 'canteen'])->name('menu.canteen');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{menu}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{menu}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{menu}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Orders
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');

    // Balance
    Route::get('/balance', [UserBalanceRequestController::class, 'index'])->name('balance.index');
    Route::post('/balance-requests', [UserBalanceRequestController::class, 'store'])->name('balance-requests.store');
});

require __DIR__.'/auth.php';
