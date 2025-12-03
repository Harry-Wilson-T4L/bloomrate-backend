<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::controller(HomeController::class)->group( function(){
    Route::get('content/{type}', 'content');
});


// ADMIN ROUTES
Route::prefix('admin')->group(function () {  

    Route::controller(AdminAuthController::class)->group( function(){
        Route::get('/', 'loginFrom');
        Route::get('login', 'loginFrom');
        Route::post('login', 'login');
    });

    Route::group(['middleware'=>'auth'], function(){
        Route::controller(AdminHomeController::class)->group( function(){
            Route::get('dashboard', 'dashboard');
            Route::get('help-and-feedback', 'helpAndFeedback');

            Route::prefix('users')->group(function () {  
                Route::get('/', 'usersList');
                Route::get('block/{id}/{is_block}', 'userBlock');
            });

            Route::prefix('status')->group(function () {  
                Route::get('/', 'statusList');
                Route::get('form', 'statusForm');
                Route::post('form', 'statusFormSubmit');
                Route::get('update/{id}/{status}', 'statusUpdate');
                Route::get('delete/{id}', 'statusDelete');

            });

            Route::prefix('interests')->group(function () {  
                Route::get('/', 'interestList');
                Route::get('form', 'interestForm');
                Route::post('form', 'interestFormSubmit');
                Route::get('update/{id}/{status}', 'interestUpdate');
                Route::get('delete/{id}', 'interestDelete');

            });

            Route::prefix('reported')->group(function () {  
                Route::get('posts', 'reportedPostList');
                Route::get('post-update/{id}/{status}', 'reportedPostUpdate');
            });

            Route::prefix('content')->group(function () {  
                Route::get('/{type}', 'getContent');
                Route::post('update/{type}', 'updateContent');
            });
        });

        Route::get('logout', [AdminAuthController::class, 'logout']);
    });

});
// ADMIN ROUTES END


Route::get('unauthorize', function () {
    return response()->json([
        'status' => 0, 
        'message' => 'Sorry User is Unauthorize'
    ], 401);
})->name('unauthorize');
