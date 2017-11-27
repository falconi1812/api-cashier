<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name"
    ];

}
