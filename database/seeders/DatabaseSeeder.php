<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use App\Models\Record;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();
        Rack::truncate();
        Category::truncate();
        Book::truncate();
        Record::truncate();

        User::create([
            "user_id" => \Str::uuid(),
            "name" => "admin_rakbukuku",
            "email" => "admin_rakbukuku@gmail.com",
            "password" => "rakbukuku"
        ]);

        User::factory(10)->create();
        Rack::factory(3)->create();
        Category::factory(10)->create();

        Book::factory(100)->create();
        Record::factory(23)->create();

        Schema::enableForeignKeyConstraints();
    }
}
