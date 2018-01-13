<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IconService;

/**
 * @SWG\Tag(
 *   name="Icons",
 *   description="Catalog of icons available"
 * )
 */
class IconsController extends Controller
{
    private $iconService;

    public function __construct(IconService $IconService)
    {
        $this->iconService = $IconService;
    }

     /**
      * @SWG\Get(
      *     path="/icons",
      *     @SWG\Response(
      *          response="200",
      *          description="Return all icons as an array",
      *          @SWG\Schema(ref="#/definitions/GetAllIcons")),
      *     tags={"Icons"},
      * )
      */
    public function getAll()
    {
        return response()->json($this->iconService->getIcons());
    }

}

?>
