<?php

namespace App\Http\Controllers;

use App\Domain\Lodge;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class LodgeController extends BaseController
{
    public function getLodges(){
        return response()->json(Lodge::all());
    }
}
