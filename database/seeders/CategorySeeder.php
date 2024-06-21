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
            'image' => 'https://static.toiimg.com/thumb/msid-110053661,width-1280,height-720,resizemode-4/110053661.jpg',
        ],
        [
            'name' => 'Korean',
            'slug' => '/korean',
            'description' => 'This is korean.',
            'image' => 'https://images.yummy.ph/yummy/uploads/2022/04/koreanfoodramyunwithtteokbokki.jpg',
        ],
        [
            'name' => 'Chinese',
            'slug' => '/chinese',
            'description' => 'This is chinese.',
            'image' => 'https://media.timeout.com/images/105441129/image.jpg',
        ],
        [
            'name' => 'Italian',
            'slug' => '/italian',
            'description' => 'This is italian.',
            'image' => 'https://theplanetd.com/images/Traditional-Italian-Food.jpg',
        ],
        [
            'name' => 'Mexican',
            'slug' => '/mexican',
            'description' => 'This is mexican.',
            'image' => 'https://images.immediate.co.uk/production/volatile/sites/30/2022/10/Pork-carnitas-b94893e.jpg?quality=90&resize=556,505',
        ],

        [
            'name' => 'Thai',
            'slug' => '/thai',
            'description' => 'This is thai.',
            'image' => 'https://www.eatthis.com/wp-content/uploads/sites/4//media/images/ext/891825630/pad-thai.jpg?quality=82&strip=1',
        ],
        [
            'name' => 'American',
            'slug' => '/american',
            'description' => 'This is american.',
            'image' => 'https://cdn.tasteatlas.com/images/toplistarticles/08c818739e4b48ce96d319c16f4cc0ca.jpg',
        ],
        [
            'name' => 'Japanese',
            'slug' => '/japanese',
            'description' => 'This is japanese.',
            'image' => 'https://s3.divcom.com/www.seafoodsource.com/images/dc6c6c379778529cc12d6b573e3d8958.jpg',
        ],
        [
            'name' => 'Vietnamese',
            'slug' => '/vietnamese',
            'description' => 'This is vietnamese.',
            'image' => 'https://www.celebritycruises.com/blog/content/uploads/2022/04/best-food-in-vietnam-hero.jpg',
        ],
        [
            'name' => 'Mediterranean',
            'slug' => '/mediterranean',
            'description' => 'This is mediterranean.',
            'image' => 'https://images.unsplash.com/photo-1485963631004-f2f00b1d6606?q=80&w=1975&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ],
        [
            'name' => 'Middle Eastern',
            'slug' => '/middle-eastern',
            'description' => 'This is middle eastern.',
            'image' => 'https://ik.imagekit.io/munchery/blog/tr:w-768/the-10-defining-dishes-of-the-middle-east-and-how-to-make-them-at-home.jpeg',
        ],
        [
            'name' => 'Nepali',
            'slug' => '/nepali',
            'description' => 'This is nepali.',
            'image' => 'https://images.unsplash.com/photo-1588644525273-f37b60d78512?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ],
        [
            'name' => 'Caribbean',
            'slug' => '/caribbean',
            'description' => 'This is caribbean.',
            'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ],
        [
            'name' => 'South American',
            'slug' => '/south-american',
            'description' => 'This is south american.',
            'image' => 'https://d2lswn7b0fl4u2.cloudfront.net/photos/pg-south-american-dishes-1668195980.jpg',
        ],
        [
            'name' => 'European',
            'slug' => '/european',
            'description' => 'This is european.',
            'image' => 'https://www.celebritycruises.com/blog/content/uploads/2023/10/european-food-boeuf-bourguignon-france-1024x684.jpg',
        ],
    ]);
}

}
