<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CommentsController;

// Route untuk user (halaman depan)
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/products/all', [ProductController::class, 'homeAllProduct'])->name('home.products.all');
Route::get('/products/{product_id}', [ProductController::class, 'productDetail'])->name('products.detail');
Route::post('/products/{id}/like', [ProductController::class, 'like'])->name('products.like');

Route::get('/categories', [CategoryController::class, 'homeCategory'])->name('home.categories');
Route::get('/categories/{id}', [CategoryController::class, 'showProducts'])->name('categories.products');

Route::middleware('auth')->group(function () {
    Route::get('/orders/product/{id}', [OrdersController::class, 'show'])->name('orders.detail');
    Route::post('/orders/product/{id}/like', [OrdersController::class, 'toggleLike'])->name('orders.like');
    Route::get('/orders/liked', [OrdersController::class, 'liked'])->name('orders.liked');
    Route::post('/orders/alamat', [OrdersController::class, 'storeAlamat'])->name('orders.alamat.store');
    Route::post('/orders/{productId}/create', [OrdersController::class, 'createOrder'])->name('orders.create');
    Route::get('/orders/{orderId}/summary', [OrdersController::class, 'orderSummary'])->name('orders.summary');
    Route::get('/orders/{orderId}/payment', [OrdersController::class, 'paymentPage'])->name('orders.payment');
    Route::patch('/orders/{orderId}/proof', [OrdersController::class, 'proofPayment'])->name('orders.proof');
    Route::get('/orders/{orderId}/receipt', [OrdersController::class, 'receipt'])->name('orders.receipt');
    Route::post('/orders/{orderId}/invoice', [OrdersController::class, 'createInvoice'])->name('orders.invoice');
    Route::get('/orders/{orderId}/pdf', [OrdersController::class, 'exportPdf'])->name('orders.pdf');
    Route::get('/orders', [OrdersController::class, 'dataPetugas'])->name('.orders');
    Route::get('/orders/status', [OrdersController::class, 'dataStatus'])->name('.orders.status');
});

// Group auth + alamat wajib
Route::middleware(['auth','alamat.wajib'])->group(function () {
    Route::post('/orders/{orderId}/invoice', [OrdersController::class, 'createInvoice'])->name('orders.invoice');
    Route::get('/orders/{orderId}/payment', [OrdersController::class, 'paymentPage'])->name('orders.payment');
});

Route::post('/products/{id}/comment', [CommentsController::class, 'store'])->name('products.comment')->middleware('auth');

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::middleware('isGuest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'loginAuth'])->name('loginAuth');

    Route::get('/signup', function () {
        return view('signup');
    })->name('signup');

    Route::post('/signup', [UserController::class, 'signup'])->name('signup.add');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/admin/orders/chart', [OrdersController::class, 'chartData'])->name('orders.chart');
    Route::get('/products/chart', [ProductController::class, 'dataChart'])->name('products.chart');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        Route::get('/export', [CategoryController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [CategoryController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [CategoryController::class, 'dataForDataTables'])->name('datatables');
    });

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [UserController::class, 'datatables'])->name('datatables');
    });

    Route::prefix('/product')->name('product.')->group(function () {
        Route::get('/chart', [ProductController::class, 'dataChart'])->name('chart');
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::put('/toggle/{id}', [ProductController::class, 'toggle'])->name('toggle');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
        Route::get('/export', [ProductController::class, 'export'])->name('export');
        Route::get('/trash', [ProductController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [ProductController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [ProductController::class, 'dataForDataTables'])->name('datatables');
    });
});

Route::middleware('isStaff')->prefix('/staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::get('/', [OrdersController::class, 'dataPetugas'])->name('index');
        Route::get('/status', [OrdersController::class, 'dataStatus'])->name('status');
    });

    Route::prefix('/promos')->name('promos.')->group(function() {
        Route::get('/', [PromoController::class, 'index'])->name('index');
        Route::get('/create', [PromoController::class, 'create'])->name('create');
        Route::post('/store', [PromoController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PromoController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PromoController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PromoController::class, 'destroy'])->name('delete');
        Route::get('/export', [PromoController::class, 'exportExcel'])->name('export');
        Route::get('/trash', [PromoController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [PromoController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [PromoController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [PromoController::class, 'dataForDataTables'])->name('datatables');
    });

});
