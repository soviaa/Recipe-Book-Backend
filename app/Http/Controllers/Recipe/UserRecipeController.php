<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRecipe;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

class UserRecipeController extends Controller
{
    public function saveRecipe(Request $request)
{
    $user = Auth::user();
    $userRecipe = UserRecipe::firstOrCreate(
        ['user_id' => $user->id],
        ['savedRecipe' => json_encode([])] // Ensure the default is a JSON encoded array
    );

    // Decode the JSON savedRecipe to an array
    $savedRecipes = json_decode($userRecipe->savedRecipe, true) ?? [];

    // Add the recipe_id to the array if it's not already there and save
    if (!in_array($request->recipe_id, $savedRecipes)) {
        $savedRecipes[] = $request->recipe_id;
        $userRecipe->savedRecipe = json_encode($savedRecipes); // Encode the array back to JSON
        $userRecipe->save();
    }

    // Return the userRecipe
    return response()->json([
        'status' => 'success',
        'userRecipe' => $userRecipe,
    ]);
}
public function unsaveRecipe(Request $request)
{
    $user = Auth::user();
    $userRecipe = UserRecipe::where('user_id', $user->id)->first();

    if ($userRecipe) {
        // Decode the JSON savedRecipe to an array
        $savedRecipes = json_decode($userRecipe->savedRecipe, true) ?? [];

        // Check if the recipe_id is already in the savedRecipes array
        if (($key = array_search($request->recipe_id, $savedRecipes)) !== false) {
            // If found, remove the recipe_id from the array and save
            unset($savedRecipes[$key]);
            $userRecipe->savedRecipe = json_encode($savedRecipes); // Encode the array back to JSON
            $userRecipe->save();
        }

        // Return the userRecipe
        return response()->json([
            'status' => 'success',
            'userRecipe' => $userRecipe
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'User has not saved any recipes'
        ]);
    }
}

    public function shareRecipe(Request $request)
    {
        $user = Auth::user();
        $userRecipe = UserRecipe::firstOrCreate(
            ['user_id' => $user->id],
            ['sharedRecipe' => []]
        );
        $sharedRecipes = $userRecipe->sharedRecipe ?? [];
        $sharedRecipes[] = $request->recipe_id;
        $userRecipe->sharedRecipe = $sharedRecipes;
        $userRecipe->save();

        return response()->json($userRecipe);
    }


public function getSavedRecipes()
{
    $user = Auth::user();
    $userRecipe = UserRecipe::where('user_id', $user->id)->first();

    if ($userRecipe) {
        // Decode the JSON savedRecipe to an array of IDs
        $savedRecipeIds = json_decode($userRecipe->savedRecipe, true) ?? [];

        // Fetch the recipes data for the saved recipe IDs
        $recipes = Recipe::whereIn('id', $savedRecipeIds)->get();

        // Iterate over each recipe to modify the image URL
        foreach ($recipes as &$recipe) {
            if (isset($recipe->image)) { // Assuming 'image' is the attribute name in your Recipe model
                $imageUrl = Storage::url($recipe->image);
                $recipe->image = asset($imageUrl); // Update the image attribute to the full URL
            }
        }

        // Return the modified recipes data
        return response()->json($recipes);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'User has not saved any recipes'
        ]);
    }
}

    public function getSharedRecipes()
    {
        $user = Auth::user();
        $userRecipe = UserRecipe::where('user_id', $user->id)->first();
        return response()->json($userRecipe ? $userRecipe->sharedRecipe : []);
    }
    public function isRecipeSaved($recipeId)
{
    $userId = Auth::id();
    $userRecipe = UserRecipe::where('user_id', $userId)->first();

    $isSaved = false;
    if ($userRecipe) {
        $savedRecipes = json_decode($userRecipe->savedRecipe, true);
        $isSaved = in_array($recipeId, $savedRecipes);
    }

    return response()->json([
        'status' => 'success',
        'isSaved' => $isSaved
    ]);
}
}
