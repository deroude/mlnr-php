<?php

namespace App\Http\Controllers;

use Log;
use App\Domain\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

    public function findInMyLodge(Request $request)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        return response()->json(User::where('lodge', $request->auth->lodge)->paginate(20));
    }

    public function whoAmI(Request $request)
    {
        return response()->json($request->auth);
    }

    public function changePass(Request $request)
    {
        Log::info($request);
        $this->validate($request, [
            'current-password' => 'required',
            'password' => 'required|min:8',
            'confirm-password' => 'required|same:password',
        ]);
        $resource = User::findOrFail($request->auth->id);

        if (!Hash::check($request['current-password'], $resource->password)) {
            abort(Response::HTTP_FORBIDDEN, 'WRONG_PASS');
        }

        $resource->password = password_hash($request['password'], PASSWORD_BCRYPT, ['cost' => 11]);
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'rank' => Rule::in(User::$RANKS),
            'role' => Rule::in(User::$ROLES),
            'status' => Rule::in(User::$STATUSES),
        ]);
        $resource = new User($request->json()->all());

        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $resource = User::findOrFail($id);

        $resource->fill($request->json()->all());
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        if (!User::destroy($id)) {
            abort(Response::HTTP_NOT_FOUND, 'Item not found');
        }
        return response()->json(['status' => 'OK']);
    }
}
