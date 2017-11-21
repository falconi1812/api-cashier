<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "code",
        "players",
        "hour_end",
        "hour_start",
        "day",
        "type_id",
        "terrain_id"
    ];

    /**
     * Get the products record associated with the location (many-to-many table).
     */
    public function products()
    {
        return $this->hasMany('App\LocationProducts', 'location_id', 'id');
    }
}
