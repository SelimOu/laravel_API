<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategorieController;
use OpenApi\Annotations as OA;

require __DIR__.'/openapi.php';

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Mon API",
 *     description="Description de mon API",
 *     @OA\Contact(
 *         email="contact@example.com"
 *     ),
 *     @OA\License(
 *         name="License MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// // Route::apiResource('product', ProductController::class);
// Route::prefix('/v1')->middleware('auth:sanctum')->group(function () {
// Route::get('/product', [ProductController::class,'index'])->name('Productindex');
// Route::delete('/product/{post}',[ProductController::class,'destroy'])->name('Productdestroy');
// Route::post('/product',[ProductController::class,'store'])->name('Productstore');
// Route::put('/product/{post}',[ProductController::class,'update'])->name('Productupdate');
// Route::get('/product/{post}',[ProductController::class,'show'])->name('Productshow');

// Route::get('/user', [UserController::class,'index'])->name('Userindex');
// Route::delete('/user/{post}',[UserController::class,'destroy'])->name('Userdestroy');
// Route::post('/user',[UserController::class,'store'])->name('Userstore');
// Route::put('/user/{post}',[UserController::class,'update'])->name('Userupdate');
// Route::get('/user/{post}',[UserController::class,'show'])->name('Usershow');

// Route::get('/categorie', [CategorieController::class,'index'])->name('Categorieindex');
// Route::delete('/categorie/{post}',[CategorieController::class,'destroy'])->name('Categoriedestroy');
// Route::post('/categorie',[CategorieController::class,'store'])->name('Categoriestore');
// Route::put('/categorie/{post}',[CategorieController::class,'update'])->name('Categorieupdate');
// Route::get('/categorie/{post}',[CategorieController::class,'show'])->name('Categorieshow');
// });

// Route::post('/register',[UserController::class,'store'])->name('Userstore');
// Route::post('/login', [UserController::class,'login'])->name('Userindex');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

/**
 * 
 * @OA\Get(
 *     path="/user",
 *     tags={"User"},
 *     summary="Get authenticated user",
 *     description="Get the currently authenticated user",
 *     security={{"sanctum":{}}},
 *     @OA\Response(response=200, description="Successful operation"),
 *     @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






// Routes de produits
/**
 * @OA\Get(
 *      path="/v1/product",
 *      tags={"Product"},
 *      summary="Get all products",
 *      description="Get all products",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::get('/v1/product', [ProductController::class,'index'])->name('Productindex');

/**
 * @OA\Get(
 *      path="/v1/product/categorie/{id}",
 *      tags={"Product"},
 *      summary="Filter products by category",
 *      description="Filter products by category ID",
 *      security={{"sanctum":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          description="ID of the category",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\Response(response=404, description="Category not found")
 * )
 */
Route::get('/v1/product/categorie/{id}', [ProductController::class, 'filtreCate'])->name('filtreCate');


/**
 * @OA\Delete(
 *      path="/v1/product/{post}",
 *      tags={"Product"},
 *      summary="Delete a product",
 *      description="Delete a product",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the product",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::delete('/v1/product/{post}',[ProductController::class,'destroy'])->name('Productdestroy');

/**
 * @OA\Post(
 *      path="/v1/product",
 *      tags={"Product"},
 *      summary="Create a new product",
 *      description="Create a new product",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/Product")
 *      )
 * )
 */
Route::post('/v1/product',[ProductController::class,'store'])->name('Productstore');

/**
 * @OA\Put(
 *      path="/v1/product/{post}",
 *      tags={"Product"},
 *      summary="Update an existing product",
 *      description="Update an existing product",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the product",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/Product")
 *      )
 * )
 */
Route::put('/v1/product/{post}',[ProductController::class,'update'])->name('Productupdate');

/**
 * @OA\Get(
 *      path="/v1/product/{post}",
 *      tags={"Product"},
 *      summary="Get a single product",
 *      description="Get a single product",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the product",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\Response(response=404, description="Product not found")
 * )
 */
Route::get('/v1/product/{post}',[ProductController::class,'show'])->name('Productshow');

// Routes d'utilisateurs
/**
 * @OA\Get(
 *      path="/v1/user",
 *      tags={"User"},
 *      summary="Get all users",
 *      description="Get all users",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::get('/v1/user', [UserController::class,'index'])->name('Userindex');

/**
 * @OA\Delete(
 *      path="/v1/user/{post}",
 *      tags={"User"},
 *      summary="Delete a user",
 *      description="Delete a user",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the user",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::delete('/v1/user/{post}',[UserController::class,'destroy'])->name('Userdestroy');

/**
 * @OA\Post(
 *      path="/v1/user",
 *      tags={"User"},
 *      summary="Create a new user",
 *      description="Create a new user",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/User")
 *      )
 * )
 */
Route::post('/v1/user',[UserController::class,'store'])->name('Userstore');

/**
 * @OA\Put(
 *      path="/v1/user/{post}",
 *      tags={"User"},
 *      summary="Update an existing user",
 *      description="Update an existing user",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the user",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/User")
 *      )
 * )
 */
Route::put('/v1/user/{post}',[UserController::class,'update'])->name('Userupdate');

/**
 * @OA\Get(
 *      path="/v1/user/{post}",
 *      tags={"User"},
 *      summary="Get a single user",
 *      description="Get a single user",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the user",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\Response(response=404, description="User not found")
 * )
 */
Route::get('/v1/user/{post}',[UserController::class,'show'])->name('Usershow');

// Routes de catégories
/**
 * @OA\Get(
 *      path="/v1/categorie",
 *      tags={"Categorie"},
 *      summary="Get all categories",
 *      description="Get all categories",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::get('/v1/categorie', [CategorieController::class,'index'])->name('Categorieindex');

/**
 * @OA\Delete(
 *      path="/v1/categorie/{post}",
 *      tags={"Categorie"},
 *      summary="Delete a category",
 *      description="Delete a category",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the category",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::delete('/v1/categorie/{post}',[CategorieController::class,'destroy'])->name('Categoriedestroy');

/**
 * @OA\Post(
 *      path="/v1/categorie",
 *      tags={"Categorie"},
 *      summary="Create a new category",
 *      description="Create a new category",
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/Categorie")
 *      )
 * )
 */
Route::post('/v1/categorie',[CategorieController::class,'store'])->name('Categoriestore');

/**
 * @OA\Put(
 *      path="/v1/categorie/{post}",
 *      tags={"Categorie"},
 *      summary="Update an existing category",
 *      description="Update an existing category",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the category",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\RequestBody(
 *          @OA\JsonContent(ref="#/components/schemas/Categorie")
 *      )
 * )
 */
Route::put('/v1/categorie/{post}',[CategorieController::class,'update'])->name('Categorieupdate');

/**
 * @OA\Get(
 *      path="/v1/categorie/{post}",
 *      tags={"Categorie"},
 *      summary="Get a single category",
 *      description="Get a single category",
 *      @OA\Parameter(
 *          name="post",
 *          in="path",
 *          description="ID of the category",
 *          required=true,
 *          @OA\Schema(type="integer")
 *      ),
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=401, description="Unauthenticated"),
 *      @OA\Response(response=404, description="Category not found")
 * )
 */
Route::get('/v1/categorie/{post}',[CategorieController::class,'show'])->name('Categorieshow');

// Autres routes
/**
 * @OA\Post(
 *      path="/register",
 *      tags={"Authentication"},
 *      summary="Register a new user",
 *      description="Register a new user",
 *      @OA\Response(response=200, description="Successful registration"),
 *      @OA\Response(response=422, description="Unprocessable entity")
 * )
 */
Route::post('/register',[UserController::class,'store'])->name('Userstore');

/**
 * @OA\Post(
 *      path="/login",
 *      tags={"Authentication"},
 *      summary="Login",
 *      description="Login with credentials",
 *      @OA\Response(response=200, description="Successful login"),
 *      @OA\Response(response=401, description="Unauthorized")
 * )
 */
Route::post('/login', [UserController::class,'login'])->name('Userlogin');
