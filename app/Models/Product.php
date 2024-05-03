<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Relations\BelongsTomany;

class Product extends Model
{
    use HasFactory;
    protected $fillable =
    ['name',
    'description',
    'price',
    'stock',
    'image'];

    public function categories()
    {
      return $this->belongsToMany(Categorie::class);
    }
}
