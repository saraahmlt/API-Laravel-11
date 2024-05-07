<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Categories",
 *     required={"title","description"},
 *     @OA\Property(property="id", type="integer", example=123),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the category"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the category"
 *     ),
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
 * )
 */

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
