<?php

use App\Http\Controllers\MangaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('home');
});

Route::get('/shop', [MangaController::class, 'index'])->name('shop');

Route::get('/product/{id}', [MangaController::class, 'show'])->name('product.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{index}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/checkout', function() {
    return view('checkout');
})->name('checkout');
Route::post('/checkout/pay', [App\Http\Controllers\CartController::class, 'checkoutPay'])->name('checkout.pay');
Route::get('/checkout/thankyou', function() {
    $pdf = request('pdf');
    return view('thankyou', compact('pdf'));
})->name('checkout.thankyou');
Route::match(['get', 'post'], '/admin', function() {
    $code = request('code');
    $sessionCode = session('admin_code');
    $correct = 'admin2025'; // Admin-Code hier anpassen
    if(request()->isMethod('post')) {
        if($code === $correct) {
            session(['admin_code' => $code]);
            return redirect('/admin');
        } else {
            return view('admin_login', ['error' => 'Falscher Code!']);
        }
    }
    if($sessionCode !== $correct) {
        return view('admin_login');
    }
    $orders = \DB::table('orders')->orderByDesc('created_at')->get();
    // Convert created_at to Carbon instance for each order
    foreach ($orders as $order) {
        $order->created_at = \Carbon\Carbon::parse($order->created_at);
    }
    $total = $orders->sum('total');
    $bookCounts = [];
    foreach($orders as $order) {
        foreach(json_decode($order->cart_json, true) as $item) {
            $bookCounts[$item['title']] = ($bookCounts[$item['title']] ?? 0) + 1;
        }
    }
    $topBook = $bookCounts ? array_keys($bookCounts, max($bookCounts))[0] : '-';
    return view('admin', compact('orders', 'total', 'topBook'));
})->name('admin');

require __DIR__.'/auth.php';
