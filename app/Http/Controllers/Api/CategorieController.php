<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Resources\CategorieResource;
use OpenApi\Annotations as OA;

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

class CategorieController extends Controller
{
    /**
     * @OA\Get(
     *      path="/v1/categorie",
     *      tags={"Categorie"},
     *      summary="Get all categories",
     *      description="Get all categories",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $categories = Categorie::all();
        return CategorieResource::collection($categories);
    }

    /**
     * @OA\Post(
     *      path="/v1/categorie",
     *      tags={"Categorie"},
     *      summary="Create a new category",
     *      description="Create a new category",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Categorie")
     *      )
     * )
     */
    public function store(StoreCategorieRequest $request)
    {
        $Categorie = Categorie::create($request->validated());
        return new CategorieResource($Categorie);
    }

    /**
     * @OA\Put(
     *      path="/v1/categorie/{post}",
     *      tags={"Categorie"},
     *      summary="Update an existing category",
     *      description="Update an existing category",
     *      security={{"sanctum":{}}},
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
    public function update(StoreCategorieRequest $request, Categorie $post )
    {
        $post->update($request->validated());
        return new CategorieResource($post);
    }

    /**
     * @OA\Delete(
     *      path="/v1/categorie/{post}",
     *      tags={"Categorie"},
     *      summary="Delete a category",
     *      description="Delete a category",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the category",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=204, description="No content"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function destroy(Categorie $post)
    {
        $post->delete();
        $post->product()->detach();
        return response(null, 204);
    }

    /**
     * @OA\Get(
     *      path="/v1/categorie/{post}",
     *      tags={"Categorie"},
     *      summary="Get a single category",
     *      description="Get a single category",
     *      security={{"sanctum":{}}},
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
    public function show($id)
    {
        $Categorie = Categorie::find($id);
        return CategorieResource::make($Categorie);
    }
}
