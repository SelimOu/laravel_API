<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Resources\CategorieResource;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return CategorieResource::collection($categories);
    }

    
    public function store(StoreCategorieRequest $request)
    {
        $Categorie = Categorie::create($request->validated());
        return new CategorieResource($Categorie);
    }


    
    public function update(StoreCategorieRequest $request, Categorie $post )
    {
        $post->update($request->validated());
        return new CategorieResource($post);
    }

    
    public function destroy(Categorie $post)
    {
        $post->delete();
        $post->product()->detach();
        return response(null, 204);
    }

    public function show($id)
    {
        $Categorie = Categorie::all();
        $Categorie = Categorie::find($id);
        return CategorieResource::make($Categorie);
    }
}
