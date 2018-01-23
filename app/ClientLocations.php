<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientLocations extends Model
{
    use SoftDeletes;

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
        return $this->hasOne('App\Locations', 'id', 'location_id');
    }

    /**
     * Get the client record associated.
     */
    public function client()
    {
        return $this->hasOne('App\Clients', 'id', 'client_id');
    }

}
