<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.home');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.home');
})->name('dashboard');

Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


//All Create
//Route::resource('category', 'CategoryController');

Route::get('categories', [CategoryController::class, 'index'])->name('admin.category.index');
Route::get('/add/category', [CategoryController::class, 'create'])->name('admin.add.category');
    Route::post('/store/category', [CategoryController::class, 'store'])->name('admin.store.category');
Route::get('/edit/category/{id}', [CategoryController::class, 'edit'])->name('admin.edit.category');
    Route::post('/update/category/{id}', [CategoryController::class, 'update'])->name('admin.update.category');
Route::get('/delete/category/{id}', [CategoryController::class, 'destroy'])->name('admin.delete.category');
