<?php

namespace App\Http\Controllers;

use App\Domain\Article;
use App\Domain\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Laravel\Lumen\Routing\Controller as BaseController;

class ArticleController extends BaseController
{
    public function findPublicArticles()
    {
        return response()->json(Article::where('access', 'PROFANE')->paginate(20));
    }

    public function findInMyLodge(Request $request)
    {
        return response()->json(Article::join('user', 'user.id', '=', 'article.author')
                ->where('lodge', '=', $request->auth->lodge)
                ->whereIn('access', ArticleController::getAccessLevels($request->auth->rank))
                ->select('article.*')
                ->paginate(20));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'published' => 'required',
            'access' => Rule::in(User::$RANKS),
        ]);
        $resource = new Article($request->json()->all());
        $resource->author=$request->auth->id;
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $resource = Article::findOrFail($id);

        $resource->fill($request->json()->all());
        $resource->save();

        return response()->json(['status' => 'success']);
    }

    public function delete($id)
    {
        if (!Article::destroy($id)) {
            abort(Response::HTTP_NOT_FOUND,'Item was not found');
        }
        return response()->json(['status' => 'OK']);
    }

    protected static function getAccessLevels($rank)
    {
        switch ($rank) {
            case 'INITIATE':
                return array('PROFANE', 'INITIATE');
            case 'APPRENTICE':
                return array('PROFANE', 'INITIATE', 'APPRENTICE');
            case 'JOURNEYMAN':
                return array('PROFANE', 'INITIATE', 'APPRENTICE', 'JOURNEYMAN');
            case 'MASTER':
                return array('PROFANE', 'INITIATE', 'APPRENTICE', 'JOURNEYMAN', 'MASTER');
            default:
                return array('PROFANE');
        }
    }
}
