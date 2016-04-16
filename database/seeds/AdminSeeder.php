<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::delete('delete from users where username="admin"');
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'type' => 'admin',
            'email' => 'admin@languageofintention.com',
            'password' => bcrypt('surveys123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
