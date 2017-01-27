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

            Route::get('survey-types/list', [
                'as' => 'admin-survey-types-list', 'uses' => 'SurveyTypeController@showList'
            ]);

            Route::get('survey-types/create', [
                'as' => 'admin-survey-types-create', 'uses' => 'SurveyTypeController@create'
            ]);

            Route::get('survey-types/update/{id}', [
                'as' => 'admin-survey-types-update', 'uses' => 'SurveyTypeController@update'
            ]);

            Route::post('survey-types/update/{id?}', [
                'as' => 'admin-survey-types-post-update', 'uses' => 'SurveyTypeController@postUpdate'
            ]);

            Route::get('survey-types/delete/{id}', [
                'as' => 'admin-survey-types-delete', 'uses' => 'SurveyTypeController@delete'
            ]);

            Route::get('surveys/list', [
                'as' => 'admin-surveys-list', 'uses' => 'SurveyController@showList'
            ]);

            Route::get('surveys/create', [
                'as' => 'admin-surveys-create', 'uses' => 'SurveyController@create'
            ]);

            Route::get('surveys/update/{id}', [
                'as' => 'admin-surveys-update', 'uses' => 'SurveyController@update'
            ]);

            Route::post('surveys/update/{id?}', [
                'as' => 'admin-surveys-post-update', 'uses' => 'SurveyController@postUpdate'
            ]);

            Route::get('surveys/delete/{id}', [
                'as' => 'admin-surveys-delete', 'uses' => 'SurveyController@delete'
            ]);

            Route::get('coupons/list', [
                'as' => 'admin-coupons-list', 'uses' => 'CouponController@showList'
            ]);

            Route::get('coupons/create', [
                'as' => 'admin-coupons-create', 'uses' => 'CouponController@create'
            ]);

            Route::get('coupons/update/{id}', [
                'as' => 'admin-coupons-update', 'uses' => 'CouponController@update'
            ]);

            Route::post('coupons/update/{id?}', [
                'as' => 'admin-coupons-post-update', 'uses' => 'CouponController@postUpdate'
            ]);

            Route::get('coupons/delete/{id}', [
                'as' => 'admin-coupons-delete', 'uses' => 'CouponController@delete'
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

            Route::post('categories/update-sort-order', [
                'as' => 'admin-categories-update-sort-order', 'uses' => 'CategoryController@updateSortOrder'
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

            Route::get('answers/create', [
                'as' => 'admin-answers-create', 'uses' => 'AnswerController@create'
            ]);

            Route::post('answers/update/{id?}', [
                'as' => 'admin-answers-post-update', 'uses' => 'AnswerController@postUpdate'
            ]);

            Route::get('answers/delete/{id}', [
                'as' => 'admin-answers-delete', 'uses' => 'AnswerController@delete'
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

    Route::get('convert', function () {


        $output= shell_exec('highcharts-export-server --infile options.json --outfile test12345.png');
        die($output);

        /**
         * This file is part of the exporting module for Highcharts JS.
         * www.highcharts.com/license
         *
         *
         * Available POST variables:
         *
         * $filename  string   The desired filename without extension
         * $type      string   The MIME type for export.
         * $width     int      The pixel width of the exported raster image. The height is calculated.
         * $svg       string   The SVG source code to convert.
         */


        // Options
//        define ('BATIK_PATH', 'export-server/batik-rasterizer-1.8.jar');

        ///////////////////////////////////////////////////////////////////////////////
//        ini_set('magic_quotes_gpc', 'off');

        $type = $_POST['type'];
        $svg = (string) $_POST['svg'];
        $filename = (string) $_POST['filename'];

        // prepare variables
        if (!$filename or !preg_match('/^[A-Za-z0-9\-_ ]+$/', $filename)) {
            $filename = 'chart';
        }
        if (get_magic_quotes_gpc()) {
            $svg = stripslashes($svg);
        }

        // check for malicious attack in SVG
        if(strpos($svg,"<!ENTITY") !== false || strpos($svg,"<!DOCTYPE") !== false){
            exit("Execution is stopped, the posted SVG could contain code for a malicious attack");
        }

        $tempName = md5(rand());

        // allow no other than predefined types
        if ($type == 'image/png') {
            $typeString = '-m image/png';
            $ext = 'png';

        } elseif ($type == 'image/jpeg') {
            $typeString = '-m image/jpeg';
            $ext = 'jpg';

        } elseif ($type == 'application/pdf') {
            $typeString = '-m application/pdf';
            $ext = 'pdf';

        } elseif ($type == 'image/svg+xml') {
            $ext = 'svg';

        } else { // prevent fallthrough from global variables
            $ext = 'txt';
        }

        $outfile = "export-server/temp/$tempName.$ext";

        if (isset($typeString)) {

            // size
            $width = '';
            if ($_POST['width']) {
                $width = (int)$_POST['width'];
                if ($width) $width = "-w $width";
            }

            // generate the temporary file
            if (!file_put_contents("export-server/temp/$tempName.svg", $svg)) {
                die("Couldn't create temporary file. Check that the directory permissions for
                    the /temp directory are set to 777.");
            }

            // Troubleshooting snippet
            /*
            $command = "/Library/Java/JavaVirtualMachines/jdk1.7.0_45.jdk/Contents/Home/bin/java -jar ". BATIK_PATH ." $typeString -d $outfile $width temp/$tempName.svg 2>&1";
            $output = shell_exec($command);
            echo "<pre>Command: $command <br>";
            echo "Output: $output</pre>";
            die;
            // */

            // Do the conversion
            die("java -jar ". BATIK_PATH ." $typeString -d $outfile $width export-server/temp/$tempName.svg");
            $output = shell_exec("java -jar ". BATIK_PATH ." $typeString -d $outfile $width export-server/temp/$tempName.svg");

            // catch error
            if (!is_file($outfile) || filesize($outfile) < 10) {
                echo "<pre>$output</pre>";
                echo "Error while converting SVG. ";

                if (strpos($output, 'SVGConverter.error.while.rasterizing.file') !== false) {
                    echo "
                    <h4>Debug steps</h4>
                    <ol>
                    <li>Copy the SVG:<br/><textarea rows=5>" . htmlentities(str_replace('>', ">\n", $svg)) . "</textarea></li>
                    <li>Go to <a href='http://validator.w3.org/#validate_by_input' target='_blank'>validator.w3.org/#validate_by_input</a></li>
                    <li>Paste the SVG</li>
                    <li>Click More Options and select SVG 1.1 for Use Doctype</li>
                    <li>Click the Check button</li>
                    </ol>";
                }
            }

            // stream it
            else {
                header("Content-Disposition: attachment; filename=\"$filename.$ext\"");
                header("Content-Type: $type");
                echo file_get_contents($outfile);
            }

            // delete it
            unlink("export-server/temp/$tempName.svg");
            unlink($outfile);

        // SVG can be streamed directly back
        } else if ($ext == 'svg') {
            header("Content-Disposition: attachment; filename=\"$filename.$ext\"");
            header("Content-Type: $type");
            echo $svg;

        } else {
            echo "Invalid type";
        }

    });

});
