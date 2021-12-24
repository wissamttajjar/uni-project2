<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OwnerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


	//Owner unauthenticated Routes
	Route::post("register" , [OwnerController::class , "register"]);
	Route::post("login" , [OwnerController::class , "login"]);

	//Product unauthenticated Routes
	Route::get("list-all-products" , [ProductController::class , "listAllProducts"]);
	//search for product with name
	//Route::get("find-product/{name}" , [ProductController::class , "findProduct"]);

	//search api
	Route::get("search/{name}", [ProductController::class , "searchProduct"]);



Route::group(["middleware" => ["auth:api"]] , function (){

	//Owner authenticated Routes
	Route::get("show-profile" , [OwnerController::class , "showProfile"]);
	Route::post("logout" , [OwnerController::class , "logOut"]);

	//product authenticated Routes
	Route::post("create-product" , [ProductController::class , "createProduct"]);
	Route::post("update-product/{id}" , [ProductController::class , "updateProduct"]);
	Route::get("list-owner-products" , [ProductController::class , "listOwnerProducts"]);
	Route::get("delete-product/{id}" , [ProductController::class , "deleteProduct"]);
	//search for single product with owner id using name
	Route::get("list-single-product/{name}" , [ProductController::class , "listSingleProduct"]);

	//category authenticated Routes
	Route::post("create-category" , [CategoryController::class , "createCategory"]);
	Route::post("update-category/{id}" , [CategoryController::class , "updateCategory"]);
	Route::get("delete-category/{id}" , [CategoryController::class , "deleteCategory"]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
