<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\SocialMediaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Create a new route for base url of api
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to Bloom Rate API . Version : 1.0.0'], 200);
});


Route::controller(AuthController::class)->group( function(){
    Route::prefix('auth')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('forgot-password', 'forgotPassword');
        Route::post('verification', 'verification');
        Route::post('re-send-code', 'reSendCode');
        Route::post('social-login', 'socialLogin');
        Route::post('recover-account', 'recoverAccount');
    });

    Route::get('content', 'content');

    Route::post('upload/file', 'uploadToS3'); // s3 bucket upload file


    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::prefix('auth')->group(function () {
            Route::post('logout', 'logout');   
            Route::post('update-password', 'updatePassword');
            Route::post('complete-profile', 'completeProfile');

            Route::post('notification-setting', 'notificationSetting');
            Route::post('user-interest', 'userInterest');
            Route::post('is-profile-private', 'isProfilePrivate');


            Route::delete('delete-account', 'deleteAccount');
            
            Route::post('enable-phone-book', 'enablePhoneBook');

            Route::get('generate-upload-url', function () {
                $s3 = \Storage::disk('s3');
                $temporaryUrl = $s3->temporaryUrl('media/post_media/video.mp4', now()->addMinutes(5));
                return response()->json(['temporary_url' => $temporaryUrl], 200);
            });
            
        });
    });
});

Route::controller(GeneralController::class)->group( function(){
    Route::prefix('general')->group(function () {
        Route::get('interest-list', 'interestList');
        Route::get('status-list', 'statusList');
        Route::get('country', 'getCountry');
        Route::get('state', 'getState');
        Route::get('city', 'getCity');
    });
});

Route::group(['middleware'=>'auth:sanctum'], function(){
    
    Route::controller(GeneralController::class)->group( function(){
        Route::prefix('general')->group(function () {
            Route::post('help-and-feedback', 'helpAndFeedback');
            Route::get('notification/list', 'notificationList');
        });
        
        Route::post('chat/attachment', 'chatAttachment');

    });

    Route::controller(SocialMediaController::class)->group( function(){
        Route::prefix('post')->group(function () {
            Route::get('list', 'listPost');   
            Route::get('detail', 'detailPost');   
            Route::post('create', 'createPost');   
            Route::post('edit', 'editPost');   
            Route::delete('delete', 'deletePost');
            Route::post('share', 'sharePost');
            Route::get('search', 'searchPost');

            Route::prefix('save')->group(function () {
                Route::get('list', 'saveListPost');
                Route::post('/', 'savePost');
            });

            Route::prefix('favourite')->group(function () {
                Route::get('list', 'favouriteListPost');
                Route::post('/', 'favouritePost');
            });
            
            Route::post('report', 'reportPost');


            Route::get('comment-list', 'postCommentList');
            Route::post('create-comment', 'postCreateComment');
            Route::delete('delete-comment', 'postDeleteComment');
            Route::post('update-comment', 'postUpdateComment');

            Route::get('comment/like-list', 'postAndCommentLikeList');
            Route::post('comment/like-unlike', 'postAndCommentLikeUnlike');

            Route::get('interest-post-list', 'groupInterestPostList');
            Route::post('interest-post', 'groupInterestPost');

            Route::post('comment-count', 'commentCount');

        });

        Route::prefix('group')->group(function () {
            Route::get('list', 'groupList');
            Route::get('detail', 'groupDetail');
            Route::post('create', 'groupCreate');
            Route::post('update', 'groupUpdate');
            Route::delete('delete', 'groupDelete');
            Route::post('leave', 'groupLeave');
            Route::get('search', 'searchGroup');
            Route::post('join', 'groupJoin');
            Route::post('cancel/request', 'groupCancelRequest');
            Route::post('accept/request', 'groupAcceptRequest');
            Route::post('request/reject', 'groupRejectRequest');
            Route::post('add/member', 'groupAddMember');
            Route::post('member', 'groupMember');
            Route::post('requested/user', 'groupRequestedUser');
            Route::post('not/follow-user', 'groupNotFollowUser');
            Route::post('member/remove', 'groupMemberRemove');


            // Route::post('clear-chat', 'clearGroupChat');
        });
    });

    Route::controller(UserController::class)->group( function(){
        Route::prefix('user')->group(function () {
            Route::get('profile', 'profile'); 
        });

        Route::prefix('follow')->group(function () {
            Route::get('requests', 'followRequests');
            Route::post('requests/accept/reject', 'followRequestAcceptReject');
            Route::post('create', 'followCreate');
            Route::get('following', 'following');
            Route::get('followers', 'followers');
        });

        Route::post('user/block/unblock', 'userBlockUnBlock');
        Route::get('user/block/list', 'userBlockList');
    });   
});


