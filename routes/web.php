<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductPageController::class, 'index'])->name('product.page.index');
Route::get('fetchdata', [ProductPageController::class, 'fetchData'])->name('product.page.fetchData');
Route::get('loadmore', [ProductPageController::class, 'loadmore'])->name('product.loadmore');

// Utils
Route::get('getProductImages/{product}', [ProductPageController::class, 'getProductImages'])->name('products.getImage');

Route::resource('/admin/product', ProductController::class, ['except' => ['show']]);
Route::get('/admin/fetchAdminProducts', [ProductController::class, 'fetchAdminProducts'])->name('admin.fetchAdminProducts');

Route::resource('/admin/tag', TagController::class, ['except' => ['show', 'edit', 'update']]);
Route::resource('/admin/color', ColorController::class, ['except' => ['show', 'edit', 'update']]);
Route::resource('/admin/category', CategoryController::class, ['except' => ['show', 'edit', 'update']]);
Route::resource('/admin/user', UserController::class, ['except' => ['show']]);

Route::get('/product/display/{name}/{name2}', [ProductController::class, 'displayImage']);
Route::delete('deleteImage/{image}', [ProductController::class, 'deleteImage']);

Route::fallback(function () {
    return view('errors.404');
});
Auth::routes();