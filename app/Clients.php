<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "last_name",
        "email",
        "phone"
    ];

    /**
     * Get the location record associated.
     */
    public function clientLocation()
    {
        return $this->hasMany('App\ClientLocations', 'client_id', 'id');
    }
}
