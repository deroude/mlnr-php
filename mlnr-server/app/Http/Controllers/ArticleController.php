<?php

namespace App\Http\Controllers;

use App\Domain\Article;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ArticleController extends BaseController
{
    public function findPublicArticles()
    {
        return response()->json(Article::where('access', 'PROFANE')->get());
    }

    public function deleteArticle($id)
    {
        if(!User::destroy($id)){
            abort(Response::HTTP_NOT_FOUND);
        }
        return response()->json(['status' => 'OK']);
    }

    public function findInMyLodge(Request $request)
    {
        return response()->json(Article::join('user', 'user.id', '=', 'article.author')
                ->where('lodge', '=', $request->auth->lodge)
                ->whereIn('access', ArticleController::getAccessLevels($request->auth->rank))
                ->select('article.*')
                ->paginate(20));
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
