<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::post('/backend/auth/login','App\Controller\Backend\AuthController@login');
Router::get('/backend/auth/logout','App\Controller\Backend\AuthController@logout');
 
Router::addGroup('/backend',function () {
    // auth info
    Router::get('/auth/info', 'App\Controller\Backend\AuthController@info');

    Router::post('/upload/image','App\Controller\Backend\UploadController@image');

    Router::get('/collections', 'App\Controller\Backend\CollectionController@index');
    Router::get('/collections/{id}', 'App\Controller\Backend\CollectionController@edit');

}, ['middleware' => [App\Middleware\JWTAuthMiddleware::class]]);

Router::get('/favicon.ico', function () {
    return '';
});
