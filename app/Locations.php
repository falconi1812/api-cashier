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
        'products_in_list',
        'products_in_payment',
        'total_in_list',
        'total_in_payment',
        'total_payed',
        'players',
        'hour_end',
        'hour_start',
        'day',
        'type_id',
        'terrain_id'
    ];
}
