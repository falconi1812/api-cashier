<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationProducts extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "product_id",
        "location_id",
        "products_in_list",
        "products_in_payment",
        "total_in_list",
        "total_in_payment",
        "total_payed"
    ];

    /**
     * Get the product record associated.
     */
    public function product()
    {
        return $this->hasOne('App\Products', 'id', 'product_id');
    }

    /**
     * Get the location record associated.
     */
    public function location()
    {
        return $this->hasMany('App\Location', 'id', 'location_id');
    }
}
