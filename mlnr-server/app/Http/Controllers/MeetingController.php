<?php

namespace App\Http\Controllers;

use App\Domain\Meeting;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class MeetingController extends BaseController
{
    public function findInMyLodge()
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        return response()->json(Meeting::where('lodge', $request->auth->lodge)->orderBy("date", "desc")->paginate(20));
    }

    public function create(Request $request)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        $this->validate($request, [
            'date' => 'required',
            'text' => 'required',
            'location' => 'required',
            'type' => Rule::in(Meeting::$TYPES),
        ]);
        $resource = new Meeting($request->json()->all());
        $resource->lodge = $request->auth->lodge;
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, $id)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        $resource = Meeting::findOrFail($id);

        $resource->fill($request->json()->all());
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        if (!Meeting::destroy($id)) {
            abort(Response::HTTP_NOT_FOUND,'Item was not found');
        }
        return response()->json(['status' => 'OK']);
    }
}
