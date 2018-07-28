<?php

namespace App\Http\Controllers;

use App\Domain\Article;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ArticleController extends BaseController
{
    public function findPublicArticles(){
        return response()->json(Article::where('access','PROFANE')->get());
    }
}
