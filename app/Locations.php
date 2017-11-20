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
        "players",
        "hour_end",
        "hour_start",
        "day",
        "type_id",
        "terrain_id"
    ];
}
