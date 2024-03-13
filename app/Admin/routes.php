<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\UserBrainysController;
use App\Admin\Controllers\UserMaterialController;
use App\Admin\Controllers\UserSyllabusController;
use App\Admin\Controllers\UserExerciseController;

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
    $router->get('user-syllabi/seed', [UserSyllabusController::class, 'seed'])->name('user-syllabi.seed');
    $router->get('user-exercises/seed', [UserExerciseController::class, 'seed'])->name('user-exercises.seed');

    $router->resource('user-brainys', UserBrainysController::class);
    $router->resource('user-materials', UserMaterialController::class);
    $router->resource('user-syllabi', UserSyllabusController::class);
    $router->resource('user-exercises', UserExerciseController::class);
});

