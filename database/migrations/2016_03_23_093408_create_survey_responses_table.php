<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('surveys_taken_id')->unsigned();
            $table->foreign('surveys_taken_id')->references('id')->on('surveys_taken');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('trait_id')->unsigned();
            $table->foreign('trait_id')->references('id')->on('traits');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->integer('answer_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->integer('answer_position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('survey_responses');
    }
}
