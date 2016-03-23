<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableAddCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function ($table) {
            $table->string('username', 100)->after('name');
            $table->integer('team_manager')->unsigned();
            $table->foreign('team_manager')->references('id')->on('users');
            $table->integer('department_id')->unsigned()->after('username');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('role_id')->unsigned()->after('department_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('coupon', 100)->after('password');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function ($table) {
            $table->dropColumn(['username', 'team_manager', 'department_id', 'role_id', 'coupon']);
        });
    }
}
