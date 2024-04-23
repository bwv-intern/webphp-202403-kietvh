<?php

use App\Http\Controllers\{
    AuthController,
    CommonController,
    GroupController,
    UserController
};
use Illuminate\Support\Facades\{Route};

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
})->middleware(['auth', 'checkLogin']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/handleLogin', [AuthController::class, 'handleLogin'])->name('handleLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/error', function () {
    return view('common.error');
})->middleware(['checkLogin', 'no-cache'])->name('error');

Route::prefix('common')->as('common.')->group(function () {
    Route::get('resetSearch', [CommonController::class, 'resetSearch'])->name('resetSearch');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'checkLogin']], function () {

    Route::group(['prefix' => 'user'], function () {
        // user list search
        Route::get('/', [UserController::class, 'userList'])->name('userList');
        Route::post('/', [UserController::class, 'searchUserList'])->name('searchUserList');

        // add
        Route::get('/add-edit-delete', [UserController::class, 'add'])->name('add');
        Route::post('/add-edit-delete/{id}', [UserController::class, 'handleAdd'])->name('handleAdd');

        // edit delele
        Route::get('/add-edit-delete/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/add-edit-delete/{id}', [UserController::class, 'handleEdit'])->name('handleEdit');
        Route::delete('/add-edit-delete/{id}', [UserController::class, 'handleDelete'])->name('handleDelete');

    });

    Route::group(['prefix' => 'group', 'middleware' => ['check-director']], function () {
        Route::get('/', [GroupController::class, 'groupList'])->name('groupList');
    });
});
