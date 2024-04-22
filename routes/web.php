<?php

use App\Http\Controllers\{
    AuthController,
    GroupController,
    UserController
};
use Illuminate\Support\Facades\{Auth, Route};

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
    return redirect()->route('login');
}) -> middleware(['auth','checkLogin']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/handleLogin', [AuthController::class, 'handleLogin'])->name('handleLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/error', function () {
    return view('common.error');
})->middleware(['checkLogin','no-cache'])->name('error');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','checkLogin', 'no-cache']], function () {
    

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'userList'])->name('userList');
        Route::post('/', [UserController::class, 'searchUserList'])->name('searchUserList');
    });

    Route::group(['prefix' => 'group'], function () {
        Route::get('/', [GroupController::class, 'groupList'])->name('groupList');
    });
});
