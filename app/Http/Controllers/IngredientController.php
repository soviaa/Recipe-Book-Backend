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

    public function getSingle($id)
    {
        $ingredient = Ingredient::where('id', $id)->first();

        if ($ingredient) {
            return response()->json([
                'status' => 'success',
                'message' => 'Ingredient retrieved successfully',
                'data' => $ingredient,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Ingredient not found',
                'data' => null,
            ], 404);
        }
    }
}
