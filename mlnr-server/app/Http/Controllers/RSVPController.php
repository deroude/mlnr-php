<?php

namespace App\Http\Controllers;

use App\Domain\RSVP;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class RSVPController extends BaseController
{
    public function findByMeeting($id)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        return response()->json(RSVP::where('meeding', $id)->paginate(20));
    }

    public function findMyInvitation($secret)
    {
        return response()->json(RSVP::where('secret', $secret));
    }

    public function create(Request $request)
    {
        if ($request->auth->rank == 'PROFANE') {
            abort(Response::HTTP_FORBIDDEN, 'RANK_TOO_LOW');
        }
        $this->validate($request, [
            'meeting' => 'required',
            'user' => 'required',
            'secret' => 'required',
        ]);
        $resource = new RSVP($request->json()->all());
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function respond(Request $request, $id)
    {
        $resource = Meeting::findOrFail($id);

        $resource->fill($request->json()->all());
        $resource->save();

        return response()->json(['status' => 'success']);
    }

}
