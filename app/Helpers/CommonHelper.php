<?php

namespace App\Helpers;

trait CommonHelper {

  public function is_multi_array($array)
  {
      rsort($array);
      return isset($array[0]) && is_array($array[0]);
  }

}

?>
