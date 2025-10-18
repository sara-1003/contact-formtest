<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;


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

Route::get("/",[ContactController::class,"index"]);
Route::post("/confirm",[ContactController::class,"confirm"]);
Route::post("/thanks",[ContactController::class,"store"]);
Route::get("/register",[AuthController::class,"index"]);
Route::post("register",[AuthController::class,"register"]);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth')->group(function(){
    Route::get("/admin",[AdminController::class,"index"])->name('admin.index');
    Route::post("/logout", [LoginController::class, "logout"])->name('logout');
    Route::get("/admin/search",[AdminController::class,"search"])->name('admin.search');
});
Route::delete('/admin/delete',[AdminController::class,'destroy']);
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');