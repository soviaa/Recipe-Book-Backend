<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::get()->toArray();
        return response()->json([
            'status' => 'success',
            'message' => 'Recipes retrieved successfully',
            'data' => $recipes
        ], 200);
    }

    public function recipeSingle($id)
    {
        $recipe = Recipe::with('user')->where('id', $id)->first();
        if($recipe){
            return response()->json([
                'status' => 'success',
                'message' => 'Recipe retrieved successfully',
                'data' => $recipe
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'failure',
                'message' => 'Recipe not found',
                'data' => null
            ], 404);
        }
    }
}
