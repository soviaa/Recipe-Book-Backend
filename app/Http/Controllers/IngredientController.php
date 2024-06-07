<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredients retrieved successfully',
            'data' => $ingredients,
        ], 200);
    }
}
