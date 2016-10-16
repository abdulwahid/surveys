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

            Route::get('download-report/{survey_taken_id}', [
                'as' => 'admin-download-report', 'uses' => 'SurveyController@downloadReport'
            ]);

            Route::get('generate-graph/{survey_taken_id}', [
                'as' => 'admin-generate-graph', 'uses' => 'SurveyController@generateGraph'
            ]);

            Route::get('logout', [
                'as' => 'admin-logout', 'uses' => 'AuthController@logout'
            ]);

            Route::get('categories/list', [
                'as' => 'admin-categories-list', 'uses' => 'CategoryController@showList'
            ]);

            Route::get('categories/create', [
                'as' => 'admin-categories-create', 'uses' => 'CategoryController@create'
            ]);

            Route::get('categories/update/{id}', [
                'as' => 'admin-categories-update', 'uses' => 'CategoryController@update'
            ]);

            Route::post('categories/update/{id?}', [
                'as' => 'admin-categories-post-update', 'uses' => 'CategoryController@postUpdate'
            ]);

            Route::get('categories/delete/{id}', [
                'as' => 'admin-categories-delete', 'uses' => 'CategoryController@delete'
            ]);

            Route::get('companies/list', [
                'as' => 'admin-companies-list', 'uses' => 'CompanyController@showList'
            ]);

            Route::get('companies/create', [
                'as' => 'admin-companies-create', 'uses' => 'CompanyController@create'
            ]);

            Route::get('companies/update/{id}', [
                'as' => 'admin-companies-update', 'uses' => 'CompanyController@update'
            ]);

            Route::post('companies/update/{id?}', [
                'as' => 'admin-companies-post-update', 'uses' => 'CompanyController@postUpdate'
            ]);

            Route::get('companies/delete/{id}', [
                'as' => 'admin-companies-delete', 'uses' => 'CompanyController@delete'
            ]);

            Route::get('departments/list', [
                'as' => 'admin-departments-list', 'uses' => 'DepartmentController@showList'
            ]);

            Route::get('departments/create', [
                'as' => 'admin-departments-create', 'uses' => 'DepartmentController@create'
            ]);

            Route::get('departments/update/{id}', [
                'as' => 'admin-departments-update', 'uses' => 'DepartmentController@update'
            ]);

            Route::post('departments/update/{id?}', [
                'as' => 'admin-departments-post-update', 'uses' => 'DepartmentController@postUpdate'
            ]);

            Route::get('departments/delete/{id}', [
                'as' => 'admin-departments-delete', 'uses' => 'DepartmentController@delete'
            ]);

            Route::get('roles/list', [
                'as' => 'admin-roles-list', 'uses' => 'RoleController@showList'
            ]);

            Route::get('roles/create', [
                'as' => 'admin-roles-create', 'uses' => 'RoleController@create'
            ]);

            Route::get('roles/update/{id}', [
                'as' => 'admin-roles-update', 'uses' => 'RoleController@update'
            ]);

            Route::post('roles/update/{id?}', [
                'as' => 'admin-roles-post-update', 'uses' => 'RoleController@postUpdate'
            ]);

            Route::get('roles/delete/{id}', [
                'as' => 'admin-roles-delete', 'uses' => 'RoleController@delete'
            ]);

            Route::get('traits/list', [
                'as' => 'admin-traits-list', 'uses' => 'TraitController@showList'
            ]);

            Route::get('traits/create', [
                'as' => 'admin-traits-create', 'uses' => 'TraitController@create'
            ]);

            Route::get('traits/update/{id}', [
                'as' => 'admin-traits-update', 'uses' => 'TraitController@update'
            ]);

            Route::post('traits/update/{id?}', [
                'as' => 'admin-traits-post-update', 'uses' => 'TraitController@postUpdate'
            ]);

            Route::get('traits/delete/{id}', [
                'as' => 'admin-traits-delete', 'uses' => 'TraitController@delete'
            ]);

            Route::get('questions/list', [
                'as' => 'admin-questions-list', 'uses' => 'QuestionController@showList'
            ]);

            Route::get('questions/create', [
                'as' => 'admin-questions-create', 'uses' => 'QuestionController@create'
            ]);

            Route::get('questions/update/{id}', [
                'as' => 'admin-questions-update', 'uses' => 'QuestionController@update'
            ]);

            Route::post('questions/update/{id?}', [
                'as' => 'admin-questions-post-update', 'uses' => 'QuestionController@postUpdate'
            ]);

            Route::get('questions/delete/{id}', [
                'as' => 'admin-questions-delete', 'uses' => 'QuestionController@delete'
            ]);

            Route::get('answers/list/{traitId?}', [
                'as' => 'admin-answers-list', 'uses' => 'AnswerController@showList'
            ]);


        });
    });
    //

    Route::get('/', function(){
        return view('survey.home');
    });

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

    Route::get('get-cities/{country_id}', function ($countryId) {
        $cities = \App\City::where('country_id', $countryId)->get();
        return response()->json($cities);
    });

});
