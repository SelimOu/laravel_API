<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTomany;
class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];

    public function product()
    {
      return $this->belongsToMany(Product::class);
    }
    
 
}
