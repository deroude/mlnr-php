<?php

namespace App\Http\Controllers;

use App\Domain\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

    public function findInMyLodge(Request $request)
    {
        return response()->json(User::where('lodge', $request->auth->lodge)->get());
    }

    public function whoAmI(Request $request)
    {
        return response()->json($request->auth);
    }
}
