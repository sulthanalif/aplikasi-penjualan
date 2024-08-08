<?php

use App\Livewire\ChartPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderDetailController;
use App\Models\Order;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/invoice/{order}', function (Order $order) {
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML(view('prints.invoice', ['order' => $order])->render());
    $mpdf->Output();
})->name('invoice');

Route::get('/order/{order}', [OrderDetailController::class, 'index'])->name('order.detail');
Route::get('/order/{order}/success', [OrderDetailController::class, 'success'])->name('success');
Route::view('/order/{order}/check', 'order-detail-guest')->name('order.detail.guest');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::group(['prefix' => 'master', 'middleware' => ['role:admin']], function () {
        Route::get('/users', function () {
            return view('master.user');
        })->name('users');

        Route::get('/users/create', function () {
            return view('master.create-user');
        })->name('users.create');

        Route::get('/product-category', function () {
            return view('master.product');
        })->name('product-category');
    });

    Route::middleware('role:admin|cashier|owner')->group(function () {
        Route::get('/order', function () {
            return view('master.order');
        })->name('orders');

        Route::view('/table', 'master.table')->name('table');

    });

    Route::middleware('role:admin|owner')->group(function () {
        Route::view('/report', 'report')->name('report');
    });
});
