<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Indian',
            'slug' => '/indian',
            'description' => 'This is  indian.',
            'image' => '/sample.jpg',
        ]);
        DB::table('categories')->insert([
            'name' => 'Nepali',
            'slug' => '/nepali',
            'description' => 'This is nepali.',
            'image' => '/sample.jpg',
        ]);
    }
}
