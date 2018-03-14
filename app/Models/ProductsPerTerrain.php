<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsPerTerrain extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_per_terrain';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "product_id",
        "terrain_id"
    ];

    /**
     * Get the product record associated. (one-to-one table).
     */
    public function product()
    {
        return $this->hasOne('App\Products', 'id', 'product_id');
    }

    /**
     * Get the location record associated. (one-to-one table).
     */
    public function terrain()
    {
        return $this->hasOne('App\Terrain', 'id', 'terrain_id');
    }
}
