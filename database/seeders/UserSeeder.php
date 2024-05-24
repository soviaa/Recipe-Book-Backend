<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'nujan',
            'firstName' => 'Nujan',
            'lastName' => 'Sitaula',
            'email' => 'nujan@recipe.com',
            'password' => Hash::make('password'),
            'image' => '/sample.jpg',
        ]);

        DB::table('users')->insert([
            'username' => 'sovia',
            'firstName' => 'Sovia',
            'lastName' => 'Manandhar',
            'email' => 'sovia@recipe.com',
            'password' => Hash::make('password'),
            'image' => '/sample.jpg',
        ]);

        DB::table('users')->insert([
            'username' => 'sam',
            'firstName' => 'Sam',
            'lastName' => 'Doey',
            'email' => 'sam@recipe.com',
            'password' => Hash::make('password'),
            'image' => '/sample.jpg',
        ]);

    }
}
