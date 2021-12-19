<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $product_id 
 * @property string $title 
 * @property string $slug 
 * @property int $status 
 * @property string $product_type 
 * @property string $price 
 * @property string $regular_price 
 * @property int $discount 
 * @property int $quantity 
 * @property string $image 
 * @property string $gallery 
 * @property string $video 
 * @property string $excerpt 
 * @property string $description 
 * @property string $rate 
 * @property int $reviews 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Product extends Model
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_VARIANT = 'variant';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_type',
        'title', 'slug', 'status', 
        'price', 'regular_price', 'quantity', 'discount',
        'description', 'excerpt', 'image', 'gallery', 'video',        
        'updated_at', 'created_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['product_id' => 'integer', 'discount' => 'integer', 'quantity' => 'integer', 'reviews' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}