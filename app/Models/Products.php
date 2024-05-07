<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="Products",
 *     required={"name", "description", "price", "stock"},
 *     @OA\Property(property="id", type="integer", example=123),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          description="The name of the product"
 *     ),
 *     @OA\Property(
 *          property="description",
 *          type="string",
 *          description="The description of the product"
 *     ),
 *     @OA\Property(
 *          property="price",
 *          type="number",
 *          format="float",
 *          description="The price of the product"
 *     ),
 *     @OA\Property(
 *          property="stock",
 *          type="integer",
 *          description="The stock of the product"
 *     ),
 *     
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-05-06T12:34:56Z",
 *         description="The timestamp when the user was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-05-06T12:34:56Z",
 *         description="The timestamp when the user was last updated"
 *     ),
 *     @OA\Property(
 *         property="categories",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Categories")
 *     )
 * )
 */

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
        return $this->belongsToMany(Categories::class, 'categories_products', 'product_id', 'category_id')->withTimestamps();
    }
}
