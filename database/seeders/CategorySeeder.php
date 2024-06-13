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
        [
            'name' => 'Indian',
            'slug' => '/indian',
            'description' => 'This is indian.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Chinese',
            'slug' => '/chinese',
            'description' => 'This is chinese.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Italian',
            'slug' => '/italian',
            'description' => 'This is italian.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Mexican',
            'slug' => '/mexican',
            'description' => 'This is mexican.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'American',
            'slug' => '/american',
            'description' => 'This is american.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Japanese',
            'slug' => '/japanese',
            'description' => 'This is japanese.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Korean',
            'slug' => '/korean',
            'description' => 'This is korean.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Thai',
            'slug' => '/thai',
            'description' => 'This is thai.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Vietnamese',
            'slug' => '/vietnamese',
            'description' => 'This is vietnamese.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Mediterranean',
            'slug' => '/mediterranean',
            'description' => 'This is mediterranean.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Middle Eastern',
            'slug' => '/middle-eastern',
            'description' => 'This is middle eastern.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'African',
            'slug' => '/african',
            'description' => 'This is african.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'Caribbean',
            'slug' => '/caribbean',
            'description' => 'This is caribbean.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'South American',
            'slug' => '/south-american',
            'description' => 'This is south american.',
            'image' => '/sample.jpg',
        ],
        [
            'name' => 'European',
            'slug' => '/european',
            'description' => 'This is european.',
            'image' => '/sample.jpg',
        ],
    ]);
}

}
