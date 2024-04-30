<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
    ];

    public function categories()
    {
        return $this->BelongsToMany(Categories::class, 'categories_products', 'product_id', 'category_id')->withTimestamps();
    }
}
