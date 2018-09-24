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

$router->get('rsvp/{secret}', ['uses' => 'RSVPController@findMyInvitation']);

$router->group(
    ['middleware' => 'jwt.auth'],
    function () use ($router) {
        $router->get('whoami', ['uses' => 'UserController@whoAmI']);
        $router->put('changePass', ['uses' => 'UserController@changePass']);
        $router->get('articles', ['uses' => 'ArticleController@findInMyLodge']);
        $router->patch('rsvp/{id}',['uses' => 'RSVPController@respond']);
        $router->post('rsvp',['uses' => 'RSVPController@create']);
        $router->get('meeting/{id}/rsvp',['uses' => 'RSVPController@findByMeeting']);
        $router->get('meeting',['uses' => 'MeetingController@findInMyLodge']);
        $router->post('meeting',['uses' => 'MeetingController@create']);
        $router->put('meeting/{id}',['uses' => 'MeetingController@update']);
        $router->delete('meeting/{id}',['uses' => 'MeetingController@delete']);
        $router->group(
            ['middleware' => 'admin'],
            function () use ($router) {
                $router->get('users', ['uses' => 'UserController@findInMyLodge']);
                $router->delete('users/{id}', ['uses' => 'UserController@delete']);
                $router->post('users', ['uses' => 'UserController@create']);
                $router->put('users/{id}', ['uses' => 'UserController@update']);

                $router->delete('articles/{id}', ['uses' => 'ArticleController@delete']);
                $router->post('articles', ['uses' => 'ArticleController@create']);
                $router->put('articles/{id}', ['uses' => 'ArticleController@update']);
            }
        );
        $router->group(
            ['middleware' => 'superadmin'],
            function () use ($router) {
                $router->get('lodges', ['uses' => 'LodgeController@getLodges']);
            }
        );
    }
);
