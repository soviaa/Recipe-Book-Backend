<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run()
     {

        DB::table('recipes')->insert([
            'name' => 'Chicken Momo',
            'description' => 'Flour dumplings filled with yummy minced chicken.',
            'prep_time' => json_encode(['hours' => 1, 'minutes' => 30]),
            'cook_time' => json_encode(['hours' => 4, 'minutes' => 10]),
            'servings' => 4,
            'difficulty' => 'Medium',
            'recipe_type' => 'Dinner',
            'image' => '/sample.jpg',
            'user_id' => 1, // assuming a user with id 1 exists
            'category_id' => 1, // assuming a category with id 1 exists
            'is_private' => false,
            'is_approved' => true,
        ]);
        DB::table('recipes')->insert([
            'name' => 'Pork Momo',
            'description' => 'Flour dumplings filled with yummy minced pork.',
            'prep_time' => json_encode(['hours' => 2, 'minutes' => 50]),
            'cook_time' => json_encode(['hours' => 1, 'minutes' => 30]),
            'servings' => 4,
            'difficulty' => 'Medium',
            'recipe_type' => 'Dinner',
            'image' => '/sample.jpg',
            'user_id' => 2, // assuming a user with id 1 exists
            'category_id' => 2, // assuming a category with id 1 exists
            'is_private' => false,
            'is_approved' => true,
        ]);
     }

}
