<?php

namespace App\Http\Controllers;

use App\Domain\Lodge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class LodgeController extends BaseController
{
    public function getLodges(){
        return response()->json(Lodge::paginate(20));
    }

    public function create(Request $request)
    {
        $data = $request->json()->all();

        $this->validate($data, [
            'name' => 'required',
            'orient' => 'required',
            'number' => 'required',
            'status' => Rule::in(Lodge::STATUSES),
        ]);
        $resource = new Lodge($data);
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();

        $resource = Lodge::findOrFail($id);

        $resource->fill($request);
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        if (!Lodge::destroy($id)) {
            abort(Response::HTTP_NOT_FOUND,'Item was not found');
        }
        return response()->json(['status' => 'OK']);
    }
}
