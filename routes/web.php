<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('categorias', CategoryController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::delete('product-images/{id}', [ProductController::class, 'destroyImage'])->name('product_images.destroy'); 

    Route::resource('compras', CompraController::class);
    Route::get('compras/pdf/{id}', [CompraController::class, 'downloadPDF'])->name('compras.pdf');
    Route::get('compras/detalle/{id}', [CompraController::class, 'detalle'])->name('compras.detalle');

    Route::resource('ventas', VentaController::class);
    Route::get('ventas/pdf/{id}', [VentaController::class, 'downloadPDF'])->name('ventas.pdf');
    Route::get('ventas/detalle/{id}', [VentaController::class, 'detalle'])->name('ventas.detalle');

    
});


require __DIR__.'/auth.php';


