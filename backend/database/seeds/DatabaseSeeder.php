<?php

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Admin
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "email" => "admin@gmail.com",
            "password" => "12345678"
        ]);

        User::create([
            "username" => "user",
            "email" => "user@gmail.com",
            "password" => "12345678"
        ]);
    }
}
