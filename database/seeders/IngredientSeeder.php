<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            ['name' => 'Salt'],
            ['name' => 'Pepper'],
            ['name' => 'Flour'],
            ['name' => 'Chicken'],
            ['name' => 'Beef'],
            ['name' => 'Pork'],
            ['name' => 'Fish'],
            ['name' => 'Rice'],
            ['name' => 'Pasta'],
            ['name' => 'Tomato'],
            ['name' => 'Onion'],
            ['name' => 'Garlic'],
            ['name' => 'Butter'],
            ['name' => 'Oil'],
            ['name' => 'Vinegar'],
            ['name' => 'Soy Sauce'],
            ['name' => 'Sugar'],
            ['name' => 'Egg'],
            ['name' => 'Milk'],
            ['name' => 'Cheese'],
            ['name' => 'Bread'],
            ['name' => 'Yogurt'],
            ['name' => 'Honey'],
            ['name' => 'Lemon'],
            ['name' => 'Orange'],
            ['name' => 'Apple'],
            ['name' => 'Banana'],
            ['name' => 'Strawberry'],
            ['name' => 'Blueberry'],
            ['name' => 'Raspberry'],
            ['name' => 'Blackberry'],
            ['name' => 'Pineapple'],
            ['name' => 'Mango'],
        ]);
    }
}
