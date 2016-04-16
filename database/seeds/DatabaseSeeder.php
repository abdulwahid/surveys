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
    }
}
