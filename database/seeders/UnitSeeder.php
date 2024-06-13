<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            ['name' => 'tbsp'],
            ['name' => 'tsp'],
            ['name' => 'g'],
            ['name' => 'kg'],
            ['name' => 'ml'],
            ['name' => 'l'],
            ['name' => 'pcs'],
            ['name' => 'cup'],
            ['name' => 'oz'],
            ['name' => 'lb'],
        ]);
    }
}
