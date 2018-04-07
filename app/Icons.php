<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icons extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "ref"
    ];

    protected $guarded =[];

}
