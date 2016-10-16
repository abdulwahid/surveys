<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('surveys_taken_id')->unsigned();
            $table->foreign('surveys_taken_id')->references('id')->on('surveys_taken')->onDelete('cascade');
            $table->integer('trait_id')->unsigned();
            $table->foreign('trait_id')->references('id')->on('traits')->onDelete('cascade');
            $table->integer('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('survey_scores');
    }
}
