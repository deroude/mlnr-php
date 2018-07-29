<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
    return response()->json(["version" => $router->app->version()]);
});

$router->get('articles/public', ['uses' => 'ArticleController@findPublicArticles']);

$router->post('auth/login', ['uses' => 'AuthController@authenticate']);

$router->group(
    ['middleware' => 'jwt.auth'],
    function () use ($router) {
        $router->get('users', ['uses' => 'UserController@findInMyLodge']);
        $router->get('whoami', ['uses' => 'UserController@whoAmI']);
        $router->get('lodges', ['uses' => 'LodgeController@getLodges']);
        $router->get('articles', ['uses' => 'ArticleController@findInMyLodge']);
        $router->group(
            ['middleware' => 'admin'],
            function () use ($router) {
                $router->delete('articles/{id}', ['uses' => 'ArticleController@deleteArticle']);
            }
        );
    }
);
