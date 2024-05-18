<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstName' => 'Nujan',
            'lastName' => 'Sitaula',
            'email' => 'nujan@recipe.com',
            'password' => 'password',
            'image' => '/sample.jpg',
        ]);

        DB::table('users')->insert([
            'firstName' => 'Sovia',
            'lastName' => 'Manandhar',
            'email' => 'sovia@recipe.com',
            'password' => 'password',
            'image' => '/sample.jpg',
        ]);

        DB::table('users')->insert([
            'firstName' => 'Sam',
            'lastName' => 'Doey',
            'email' => 'sam@recipe.com',
            'password' => 'password',
            'image' => '/sample.jpg',
        ]);

    }
}
