<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategorieController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('product', ProductController::class);
Route::prefix('/v1')->middleware('auth:sanctum')->group(function () {
Route::get('/product', [ProductController::class,'index'])->name('Productindex');
Route::delete('/product/{post}',[ProductController::class,'destroy'])->name('Productdestroy');
Route::post('/product',[ProductController::class,'store'])->name('Productstore');
Route::put('/product/{post}',[ProductController::class,'update'])->name('Productupdate');
Route::get('/product/{post}',[ProductController::class,'show'])->name('Productshow');

Route::get('/user', [UserController::class,'index'])->name('Userindex');
Route::delete('/user/{post}',[UserController::class,'destroy'])->name('Userdestroy');
Route::post('/user',[UserController::class,'store'])->name('Userstore');
Route::put('/user/{post}',[UserController::class,'update'])->name('Userupdate');
Route::get('/user/{post}',[UserController::class,'show'])->name('Usershow');

Route::get('/categorie', [CategorieController::class,'index'])->name('Categorieindex');
Route::delete('/categorie/{post}',[CategorieController::class,'destroy'])->name('Categoriedestroy');
Route::post('/categorie',[CategorieController::class,'store'])->name('Categoriestore');
Route::put('/categorie/{post}',[CategorieController::class,'update'])->name('Categorieupdate');
Route::get('/categorie/{post}',[CategorieController::class,'show'])->name('Categorieshow');
});

Route::post('/register',[UserController::class,'store'])->name('Userstore');
Route::post('/login', [UserController::class,'login'])->name('Userindex');