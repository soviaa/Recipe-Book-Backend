<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

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

        // Check if the user has an image
        if ($recipe->user->image) {
            // Generate the image URL
            $imageUrl = Storage::url($recipe->user->image);
            $recipe->user->image = asset($imageUrl);
        }
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
