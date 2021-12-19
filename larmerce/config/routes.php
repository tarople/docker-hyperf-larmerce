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
    Router::get('/collections/{id}', 'App\Controller\Backend\CollectionController@detail');
    Router::post('/collections/create', 'App\Controller\Backend\CollectionController@create');
    Router::post('/collections/update', 'App\Controller\Backend\CollectionController@update');
    Router::get('/collections/delete/{id}', 'App\Controller\Backend\CollectionController@delete');

    Router::get('/products', 'App\Controller\Backend\ProductController@index');
    Router::get('/products/{id}', 'App\Controller\Backend\ProductController@detail');
    Router::post('/products/create', 'App\Controller\Backend\ProductController@create');
    Router::post('/products/update', 'App\Controller\Backend\ProductController@update');
    Router::get('/products/delete/{id}', 'App\Controller\Backend\ProductController@delete');

}, ['middleware' => [App\Middleware\JWTAuthMiddleware::class]]);

Router::get('/favicon.ico', function () {
    return '';
});
