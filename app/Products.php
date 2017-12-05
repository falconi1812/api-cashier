<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
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

    protected $guarded =[];

    /**
     * Get the icon record associated with the location (many-to-many table).
     */
    public function Icon()
    {
        return $this->hasOne('App\Icons', 'id', 'icon_id');
    }

}
