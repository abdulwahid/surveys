<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function()
    {

        Route::group(['middleware' => 'guest'], function () {

            Route::get('login', [
                'as' => 'admin-login', 'uses' => 'AuthController@login'
            ]);

            Route::post('login', [
                'as' => 'admin-post-login', 'uses' => 'AuthController@postLogin'
            ]);
        });

        Route::group(['middleware' => ['auth', 'admin']], function () {

            Route::get('surveys-taken', [
                'as' => 'admin-surveys-taken', 'uses' => 'SurveyController@surveysTaken'
            ]);

            Route::get('logout', [
                'as' => 'admin-logout', 'uses' => 'AuthController@logout'
            ]);
        });
    });
    //

    Route::get('/', [
        'as' => 'home', 'uses' => 'SurveyController@home'
    ]);

    Route::post('start-survey', [
        'as' => 'start-survey', 'uses' => 'SurveyController@startSurvey'
    ]);

    Route::get('start-survey', function () {
        return redirect('/');
    });

    Route::post('save-survey-response', [
        'as' => 'save-survey-response', 'uses' => 'SurveyController@saveSurveyResponse'
    ]);

    Route::get('thank-you', function () {
        return view('survey.thank-you');
    });

    Route::get('/home', 'HomeController@index');

});
