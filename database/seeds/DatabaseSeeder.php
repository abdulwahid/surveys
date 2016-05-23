<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesAndCitiesTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(TestDataSeeder::class);
    }
}

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path() . '/seeds/surveys.sql'));
    }
}