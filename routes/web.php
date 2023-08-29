<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

use App\Services\CaptchaService;
use Illuminate\Http\Request;

$router->group(['middleware' => 'throttle:660:1'], function () use ($router) {
    $router->get('captcha', fn(Request $request) => success(CaptchaService::get(85, 28)));

    $router->post('auth/sign-in', 'AuthController@signIn');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/', function (Request $request) use ($router) {
        return success(config('app'));
    });
});
