<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Str;

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

    public function addRecipe(Request $request)
    {
       try{

           $validatedData = $request->validate([
               'name' => 'required',
               'description' => 'required',
               'prep_time' => 'required',
               'cook_time' => 'required',
               'servings' => 'required',
               'difficulty' => 'nullable',
               'recipe_type' => 'nullable',
               'image' => 'nullable',
               'category_id' => 'nullable',
               'ingredients' => 'required|array',
               'ingredients.*.id' => 'required|exists:ingredients,id',
               'ingredients.*.quantity' => 'required|numeric',

            ]);

            $validatedData['user_id'] = auth()->user()->id;

            $recipe = Recipe::create($validatedData);
            if($request->hasFile('image')) {
                $recipe->image = $this->storeImage($recipe, $request);
                $recipe->save();
            }
            $ingredients = [];
            foreach ($validatedData['ingredients'] as $ingredientData) {
                $ingredients[$ingredientData['id']] = $ingredientData['quantity'];
            }

            $recipe->ingredients = json_encode($ingredients);
            $recipe->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Recipe added successfully',
                'data' => $recipe
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'failure',
                'message' => 'Recipe not added . ' . $e->getMessage(),
                'data' => null
            ], 400);
        }
    }

    private function storeImage(Recipe $recipe, Request $request)
    {
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $timestamp = time();
            $fileExtension = $file->getClientOriginalExtension();
            $newFileName = $filename . '_' . $timestamp . '.' . $fileExtension;
            $path = $file->storeAs('public/recipes', $newFileName);

            // Return the path of the stored image
            return $path;
        }

        // Return null if there's no image in the request
        return null;
    }

    public function addIngredient(Request $request, Recipe $recipe)
    {
        try {
            $validatedData = $request->validate([
                'ingredients' => 'required|array',
                'ingredients.*.id' => 'required|exists:ingredients,id',
                'ingredients.*.quantity' => 'required|numeric',
            ]);

            // Decode the existing ingredients from JSON to an array
            $existingIngredients = json_decode($recipe->ingredients, true) ?? [];

            foreach ($validatedData['ingredients'] as $ingredientData) {
                // If the ingredient already exists, add the new quantity to the existing quantity
                if (isset($existingIngredients[$ingredientData['id']])) {
                    $existingIngredients[$ingredientData['id']] += $ingredientData['quantity'];
                } else {
                    // If the ingredient doesn't exist, add it to the array
                    $existingIngredients[$ingredientData['id']] = $ingredientData['quantity'];
                }
            }

            // Encode the ingredients array back to JSON
            $recipe->ingredients = json_encode($existingIngredients);
            $recipe->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Ingredients updated successfully',
                'data' => $recipe
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Ingredients not updated: ' . $e->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public function getIngredient(Recipe $recipe)
    {
        $ingredients = json_decode($recipe->ingredients, true) ?? [];

        return response()->json([
            'status' => 'success',
            'message' => 'Ingredients retrieved successfully',
            'data' => $ingredients
        ], 200);
    }

}
