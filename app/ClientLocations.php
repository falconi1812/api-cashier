<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientLocations extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "client_id",
        "location_id",
        "day"
    ];

    /**
     * Get the location record associated.
     */
    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    /**
     * Get the client record associated.
     */
    public function client()
    {
        return $this->hasOne('App\Client', 'id', 'client_id');
    }

}
