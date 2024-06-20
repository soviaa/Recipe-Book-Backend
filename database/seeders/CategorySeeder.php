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
            'image' => 'https://images.yummy.ph/yummy/uploads/2022/07/koreanfoodguidemainimage.jpg',
        ],
        [
            'name' => 'Chinese',
            'slug' => '/chinese',
            'description' => 'This is chinese.',
            'image' => 'https://i.pinimg.com/236x/a0/32/da/a032daf3c4b9950b96ae99ee65812c3e.jpg',
        ],
        [
            'name' => 'Italian',
            'slug' => '/italian',
            'description' => 'This is italian.',
            'image' => 'https://www.foodies.pk/wp-content/uploads/2020/04/italian-cuisine-italian-food-scaled.jpeg',
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
            'image' => 'https://www.savoredjourneys.com/wp-content/uploads/2021/11/thai-food.jpg',
        ],
        [
            'name' => 'American',
            'slug' => '/american',
            'description' => 'This is american.',
            'image' => 'https://d2lswn7b0fl4u2.cloudfront.net/photos/pg-american-dishes-1652886459.jpg',
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
