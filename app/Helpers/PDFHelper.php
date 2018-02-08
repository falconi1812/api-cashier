<?php

namespace App\Helpers;

trait PDFHelper {

  private $basePath = 'tmp/invoices/';

  public function createName(...$arg)
  {
      $name = '';

      foreach ($arg as $value) {
          $name .= $value;
      }

      return "{$name}.pdf";
  }

  public function createDir($name = '')
  {
      return $this->basePath . date('Y'). '/' .date('m') . '/' . date('d') . '/' . $name;
  }

}

?>
