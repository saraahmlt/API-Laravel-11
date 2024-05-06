<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function posts()
    {
        return $this->belongsToMany(Product::class, 'categories_products', 'product_id', 'category_id')->withTimestamps();
    }
    
}
