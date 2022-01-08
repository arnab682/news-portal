<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\SubDistrictController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\RoleController;

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


// Admin SubCategory All Routes
Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('admin.subcategory.index');
Route::get('/add/subcategory', [SubCategoryController::class, 'create'])->name('admin.add.subcategory');
    Route::post('/store/subcategory', [SubCategoryController::class, 'store'])->name('admin.store.subcategory');
Route::get('/edit/subcategory/{id}', [SubCategoryController::class, 'edit'])->name('admin.edit.subcategory');
    Route::post('/update/subcategory/{id}', [SubCategoryController::class, 'update'])->name('admin.update.subcategory');
Route::get('/delete/subcategory/{id}', [SubCategoryController::class, 'destroy'])->name('admin.delete.subcategory');


// Admin District All Routes
Route::get('/district', [DistrictController::class, 'index'])->name('admin.district.index');
Route::get('/add/district', [DistrictController::class, 'create'])->name('admin.add.district');
    Route::post('/store/district', [DistrictController::class, 'store'])->name('admin.store.district');
Route::get('/edit/district/{id}', [DistrictController::class, 'edit'])->name('admin.edit.district');
    Route::post('/update/district/{id}', [DistrictController::class, 'update'])->name('admin.update.district');
Route::get('/delete/district/{id}', [DistrictController::class, 'destroy'])->name('admin.delete.district');


// Admin SubDistrict All Routes
Route::get('/subdistrict', [SubDistrictController::class, 'index'])->name('admin.subdistrict.index');
Route::get('/add/subdistrict', [SubDistrictController::class, 'create'])->name('admin.add.subdistrict');
    Route::post('/store/subdistrict', [SubDistrictController::class, 'store'])->name('admin.store.subdistrict');
Route::get('/edit/subdistrict/{id}', [SubDistrictController::class, 'edit'])->name('admin.edit.subdistrict');
    Route::post('/update/subdistrict/{id}', [SubDistrictController::class, 'update'])->name('admin.update.subdistrict');
Route::get('/delete/subdistrict/{id}', [SubDistrictController::class, 'destroy'])->name('admin.delete.subdistrict');


// Admin Posts All Routes
Route::get('/allpost', [PostController::class, 'index'])->name('admin.all.post');
Route::get('/createpost', [PostController::class, 'create'])->name('admin.create.post');
    Route::post('/store/post', [PostController::class, 'store'])->name('admin.store.post');
Route::get('/edit/post/{id}', [PostController::class, 'edit'])->name('admin.edit.post');
    Route::post('/update/post/{id}', [PostController::class, 'update'])->name('admin.update.post');
Route::get('/delete/post/{id}', [PostController::class, 'destroy'])->name('admin.delete.post');

// Json Data for Category and District
Route::get('/get/subcategory/{category_id}', [PostController::class, 'GetSubCategory']);
Route::get('/get/subdistrict/{district_id}', [PostController::class, 'GetSubDistrict']);
