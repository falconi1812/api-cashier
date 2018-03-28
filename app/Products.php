<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "price",
        "icon_id"
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $guarded =[];

    /**
     * Get the icon record associated with the location (one-to-many table).
     */
    public function Icon()
    {
        return $this->hasOne('App\Icons', 'id', 'icon_id');
    }

    /**
     * Get the all types for this product (many-to-many table).
     */
    public function Type()
    {
        return $this->hasMany('App\Models\ProductsPerTypeLocation', 'product_id', 'id');
    }

}
