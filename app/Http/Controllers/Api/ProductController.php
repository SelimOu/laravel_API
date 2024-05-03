<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        
        $products =Product::all();
       
        
        return ProductResource::collection($products);
    }

    
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        
        $categories = explode(',' ,$request->categorie_id);
        foreach($categories as $categorie){
        $product->categories()->attach($categorie);
        }

        $this->StoreImg($product);



        return new ProductResource($product);
        
    }


    
    public function update(StoreProductRequest $request, Product $post )
    {
        $imagepath=public_path('storage/'.$post->image);
        unlink($imagepath);
        $post->update($request->validated());

        $categories = explode(',' ,$request->categorie_id);
        
        $post->categories()->sync($categories);
        
        $this->StoreImg($post);
        
        return new ProductResource($post);
    }

    
    public function destroy(Product $post)
    {
        $post->delete();
        $post->categories()->detach();

        $imagepath=public_path('storage/'.$post->image);
        unlink($imagepath);
        
        return response(null, 204);
    }

    public function show($id)
    {
        // $product = Product::all();
        $product = Product::find($id);
        // dd($product);

        return ProductResource::make($product);
    }

    private function StoreImg(Product $product){

        if(request('image')){
            $product->update([
                'image'=>request('image')->store('images', 'public'),
            ]);
        }
    }

}
