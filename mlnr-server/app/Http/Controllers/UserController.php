<?php

namespace App\Http\Controllers;

use App\Domain\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

    public function findInMyLodge(Request $request)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN,'RANK_TOO_LOW');
        }
        return response()->json(User::where('lodge', $request->auth->lodge)->paginate(20));
    }

    public function whoAmI(Request $request)
    {
        return response()->json($request->auth);
    }

    public function deleteUser($id)
    {
        if(!User::destroy($id)){
            abort(Response::HTTP_NOT_FOUND);
        }
        return response()->json(['status' => 'OK']);
    }
}
