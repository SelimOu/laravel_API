<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/product",
     *      tags={"Product"},
     *      summary="Get all products",
     *      description="Get all products",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/product",
     *      tags={"Product"},
     *      summary="Create a new product",
     *      description="Create a new product",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        if($request->categorie_id){
        $categories = explode(',' ,$request->categorie_id);
        foreach($categories as $categorie){
            $product->categories()->attach($categorie);
        }
    }

        $this->StoreImg($product);

        return new ProductResource($product);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/product/{post}",
     *      tags={"Product"},
     *      summary="Update an existing product",
     *      description="Update an existing product",
     *      security={{"sanctum":{}}},
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
    public function update(StoreProductRequest $request, Product $post)
    {
        // $imagepath = public_path('storage/' . $post->image);
        // unlink($imagepath);
        $post->update($request->validated());
        if($request->categorie_id){
        $categories = explode(',' ,$request->categorie_id);
        $post->categories()->sync($categories);
        }
        $this->StoreImg($post);

        return new ProductResource($post);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/product/{post}",
     *      tags={"Product"},
     *      summary="Delete a product",
     *      description="Delete a product",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the product",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=204, description="No content"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function destroy(Product $post)
    {
        $post->delete();
        $post->categories()->detach();

        $imagepath = public_path('storage/' . $post->image);
        unlink($imagepath);
        
        return response(null, 204);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/product/{post}",
     *      tags={"Product"},
     *      summary="Get a single product",
     *      description="Get a single product",
     *      security={{"sanctum":{}}},
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
    public function show($id)
    {
        $product = Product::find($id);
        return ProductResource::make($product);
    }

    /**
 * @OA\Get(
 *      path="/api/v1/filtreCate/{id}",
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
public function filtreCate($id){
    // Récupérer toutes les catégories
    $categorie = Categorie::all();
    
    // Filtrer les produits qui ont la catégorie spécifiée
    $products = Product::whereHas('categories', function ($query) use ($id) {
        $query->where('categories.id', $id);
    })->latest()->paginate(2);
    
    // Retourner la collection de ressources représentant les produits filtrés
    return ProductResource::collection($products);
}

    

    private function StoreImg(Product $product)
    {
        if (request('image')) {
            $product->update([
                'image' => request('image')->store('images', 'public'),
            ]);
        }
    }

     /**
     * @OA\Get(
     *      path="/api/v1/welcome",
     *      tags={"Welcome"},
     *      summary="Get all products",
     *      description="Get all products",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function welcome()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }
}
