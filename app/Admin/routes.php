<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\UserBrainysController;
use App\Admin\Controllers\UserMaterialController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('user-brainys/seed', [UserBrainysController::class, 'seed'])->name('user-brainys.seed');
    $router->get('user-materials/seed', [UserMaterialController::class, 'seed'])->name('user-materials.seed');
    $router->resource('user-brainys', UserBrainysController::class);
    $router->resource('user-materials', UserMaterialController::class);
});

