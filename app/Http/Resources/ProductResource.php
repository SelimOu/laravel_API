<?php

namespace App\Http\Resources;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        // $products = Product::all();
        // foreach($products as $product){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock'=> $this->stock,
            'image'=>$this->image,
            'created_at' => $this->created_at,
            // 'categorie_title'=>$this->categories->pluck('title')
        ];
    }
// }
    }

