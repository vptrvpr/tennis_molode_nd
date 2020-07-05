<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group( [ 'middleware' => 'auth:api' ], function() {
    Route::post( 'logout', 'Auth\LoginController@logout' );

    Route::get( '/user', 'Auth\UserController@current' );

    Route::patch( 'settings/profile', 'Settings\ProfileController@update' );
    Route::patch( 'settings/password', 'Settings\PasswordController@update' );


    Route::group( [ 'middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin' ], function() {
        Route::get( '/user', 'UserController@get' );
        Route::post( '/user/active/{userId}', 'UserController@active' );
    } );

    Route::get( 'court/get', 'CourtController@get' );
    Route::post( 'court/reservation', 'CourtController@reservation' );
    Route::delete( 'court/reservation/{id}', 'CourtController@cancelReservation' );
    Route::get( 'set-active-user/{userId}', 'CourtController@setActiveUser' );
} );

Route::group( [ 'middleware' => 'guest:api' ], function() {
    Route::post( 'login', 'Auth\LoginController@login' );
    Route::post( 'register', 'Auth\RegisterController@register' );

    Route::post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' );
    Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' );

    Route::post( 'email/verify/{user}', 'Auth\VerificationController@verify' )->name( 'verification.verify' );
    Route::post( 'email/resend', 'Auth\VerificationController@resend' );

    Route::post( 'oauth/{driver}', 'Auth\OAuthController@redirectToProvider' );
    Route::get( 'oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback' )->name( 'oauth.callback' );
} );
