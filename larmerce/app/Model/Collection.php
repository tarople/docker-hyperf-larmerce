<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $collection_id 
 * @property string $title 
 * @property string $slug 
 * @property int $sort 
 * @property int $status 
 * @property string $image 
 * @property string $description 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Collection extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection';

    protected $primaryKey = 'collection_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'image', 'description',        
        'status', 'sort',         
        'created_at', 'updated_at'
    ];
    
}