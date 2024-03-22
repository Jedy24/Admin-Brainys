<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\UserBrainysController;
use App\Admin\Controllers\UpdateMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('user-brainys/forgot-password/{user_id}', [UserBrainysController::class, 'forgotPassword'])->name('admin.user-brainys.forgot-password');
Route::get('update-messages/send-updates', [UpdateMessageController::class, 'sendUpdates'])->name('admin.update-messages.send-updates');
