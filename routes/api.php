<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\ProductsController;


/**
 * frontend routes
 */
Route::POST('/login',[AuthController::class,"login"]);
Route::POST('/register',[AuthController::class,"register"]);

Route::get('/frontendCategories',[FrontendController::class,"categories"]);
Route::get('/frontendCategories/{slug}',[FrontendController::class,"productsByCategory"]);
Route::get('/frontendProduct/{category_slug}/{product_slug}',[FrontendController::class,"getProduct"]);
Route::post('/add-to-cart',[CartController::class,"addToCart"]);
Route::get('/view-cart',[CartController::class,"viewCart"]);
Route::put('/updateCart/{cart_id}/{scope}',[CartController::class,"updateCart"]);
Route::delete('/deleteItem/{cart_id}',[CartController::class,"deleteItem"]);



/**
 * admin routes
 */
Route::middleware(['auth:sanctum','admin'])->group(function () {
     //category
    Route::post('/category/create', [CategoryController::class,"store"]);
    Route::get('/categories', [CategoryController::class,"index"]);
    Route::put('/category/update/{id}', [CategoryController::class,"update"]);
    Route::get('/category/edit/{id}', [CategoryController::class,"edit"]);
    Route::delete('/category/delete/{id}', [CategoryController::class,"destroy"]);
    //products
    Route::Post('/product/create', [ProductsController::class,"store"]);
    Route::get('/products', [ProductsController::class,"index"]);
    Route::post('/product/update/{id}', [ProductsController::class,"update"]);
    Route::get('/product/edit/{id}', [ProductsController::class,"edit"]);
    Route::delete('/product/delete/{id}', [ProductsController::class,"destroy"]);

    Route::get('/checkAuthentication', function () {
       return response()->json([
            "message"=>"you are in",
             "status"=>200
        ],200);
    });

});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::POST('/logout',[AuthController::class,"logout"]);
});

