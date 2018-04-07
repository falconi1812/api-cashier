<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsPerTypeLocation extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_per_type_location';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "product_id",
        "type_id"
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
    public function type()
    {
        return $this->hasOne('App\Type', 'id', 'type_id');
    }
}
