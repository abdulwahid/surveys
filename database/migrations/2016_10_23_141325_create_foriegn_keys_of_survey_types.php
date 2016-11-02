<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForiegnKeysOfSurveyTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function($table) {
            $table->integer('survey_type_id')->unsigned()->after('id');
            $table->foreign('survey_type_id')->references('id')->on('survey_types')->onDelete('cascade');
        });

        Schema::table('categories', function($table) {
            $table->integer('survey_type_id')->unsigned()->after('id');
            $table->foreign('survey_type_id')->references('id')->on('survey_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function($table) {
            $table->dropColumn('survey_type_id');
        });

        Schema::table('categories', function($table) {
            $table->dropColumn('survey_type_id');
        });
    }
}
