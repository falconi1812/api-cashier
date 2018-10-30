<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      "product_id",
      "location_id",
      "type_id",
      "quantity"
  ];

  /**
   * Get the product record associated. (one-to-one table).
   */
  public function product()
  {
      return $this->hasOne('App\Products', 'id', 'product_id');
  }

  /**
   * Get the location record associated. (one-to-one table).
   */
  public function location()
  {
      return $this->hasOne('App\Location', 'id', 'location_id');
  }

  /**
   * Gives all the roles for this model.
   */
  public function rules()
  {
      return [
            'product_id' => 'required|integer',
            'location_id' => 'required|integer',
            'type_id' => 'required|integer'
        ];
  }

}
