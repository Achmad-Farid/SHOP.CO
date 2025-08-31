<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  CategoryController, ProductController, UploadController,
  ReviewController, ProductFaqController, CartController, OrderController
};
use App\Http\Controllers\AuthController;


/*
Health check (publik)
*/
Route::get('/health', fn() => response()->json(['ok' => true]));

/*
API v1
*/
Route::prefix('v1')->group(function () {



  // ===== Auth =====
    Route::middleware('web')->group(function () {
        // Dapatkan XSRF-TOKEN cookie (untuk axios/fetch withCredentials)
        Route::get('auth/csrf-cookie', [AuthController::class, 'csrf'])->name('auth.csrf');

        // Register & Login (membuat/menetapkan session)
        Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('auth/login',    [AuthController::class, 'login'])->name('auth.login');
    });

    // ===== Perlu login (session) =====
    Route::middleware(['web','auth:sanctum'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/me',      [AuthController::class, 'me'])->name('auth.me');
    });

  /*
  | KATALOG (PUBLIK) - Semua read-only: tidak perlu login
  */
  Route::prefix('catalog')->group(function () {
    // Kategori
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

    // Produk listing & detail
    Route::get('products', [ProductController::class, 'index'])->name('products.index'); // ?category_slug=&q=&color_id=&size_id=&min_price=&max_price=&sort=
    Route::get('products/latest', [ProductController::class, 'latest'])->name('products.latest');
    Route::get('products/bestseller', [ProductController::class, 'bestseller'])->name('products.bestseller');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');        // by id
    Route::get('p/{slug}', [ProductController::class, 'showBySlug'])->name('products.showBySlug');     // by slug

    // Review & FAQ (read-only publik)
    Route::get('products/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('products/{product}/faqs', [ProductFaqController::class, 'index'])->name('faqs.index');
  });

  /*
-
  | UPLOAD GAMBAR
-
  | Catatan:
  |  - Jika upload boleh publik (misal untuk prototipe), biarkan tanpa auth.
  |  - PRODUKSI: lebih aman wajib login (admin) => pindahkan route ini
  |    ke grup auth di bawah & tambahkan can:manage-products.
  */


  /*
-
  | AUTH REQUIRED - Perlu login
-
  */
  Route::middleware('auth:sanctum')->group(function () {

    // ===== Reviews =====
    // Tulis review suatu produk (butuh identitas user)
    Route::post('products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Hapus review 
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])
      ->name('reviews.destroy'); // + middleware policy kalau sudah dibuat

    // ===== FAQs =====
    // User bertanya (tanya masuk status "pending")
    Route::post('products/{product}/faqs', [ProductFaqController::class, 'store'])->name('faqs.store');

    // Admin/Moderator menjawab pertanyaan
    Route::put('faqs/{faq}/answer', [ProductFaqController::class, 'answer'])
      ->middleware('can:answer,faq')   // Policy: hanya role tertentu yang boleh
      ->name('faqs.answer');

    // Hapus FAQ (pemilik pertanyaan / admin)
    Route::delete('faqs/{faq}', [ProductFaqController::class, 'destroy'])
      ->name('faqs.destroy'); // + policy sesuai kebutuhan

    // ===== Cart =====
    Route::prefix('cart')->group(function () {
      // Cart aktif milik user
      Route::get('/', [CartController::class, 'show'])->name('cart.show');

      // Tambah item ke cart
      Route::post('items', [CartController::class, 'addItem'])->name('cart.items.add');

      // Ubah qty item
      Route::put('items/{item}', [CartController::class, 'updateItem'])->name('cart.items.update');

      // Hapus item dari cart
      Route::delete('items/{item}', [CartController::class, 'removeItem'])->name('cart.items.remove');

      // Kosongkan cart
      Route::delete('clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // ===== Orders =====
    // Checkout dari cart aktif -> membuat order
    Route::post('orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');

    // Riwayat order milik user login
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    // Detail order milik user login
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
  });

  /*
  | ADMIN (AUTH + PERMISSION)
  */
  Route::middleware(['auth:sanctum', 'can:manage-products'])->group(function () {
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::post('upload', [UploadController::class, 'store'])->name('upload.store');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
  });
});
