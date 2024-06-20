<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Fetches all categories from the database.
     * The categories are then converted to an array and returned in a JSON response.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = Category::all();
        // foreach ($categories as $category) {
        //     if ($category->image) {
        //         $imageUrl = Storage::url($category->image);
        //         $category->image = asset($imageUrl);
        //     }
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
        ], 200);
    }

    public function getSingle($id){
        $category = Category::with('recipes')->where('id', $id)->first();

        if(!$category){
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
        foreach ($category->recipes as $recipe) {
            if ($recipe->image) {
                $imageUrl = Storage::url($recipe->image);
                $recipe->image = asset($imageUrl);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully',
            'data' => $category,
        ], 200);
    }

    public function category(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $category->image = $this->storeImage($category, $request);
        }

        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category added successfully',
            'data' => $category,
        ], 200);
    }
    private function storeCategoryImage(Category $category, Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $timestamp = time();
            $fileExtension = $file->getClientOriginalExtension();
            $newFileName = $filename.'_'.$timestamp.'.'.$fileExtension;
            $path = $file->storeAs('public/categories', $newFileName);

            // Return the path of the stored image
            return $path;
        }

        // Return null if there's no image in the request
        return null;
    }
}
