<?php

use Illuminate\Database\Seeder;

class CountriesAndCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::delete('delete from cities');
        DB::delete('delete from countries');
        DB::unprepared(file_get_contents(database_path() . '/seeds/world.sql'));
    }
}
