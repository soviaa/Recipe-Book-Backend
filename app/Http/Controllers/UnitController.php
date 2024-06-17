<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::get();

        return response()->json([
            'status' => 'success',
            'message' => 'Units retrieved successfully',
            'data' => $units,
        ], 200);
    }

    public function getSingle($id)
    {
        $unit = Unit::where('id', $id)->first();

        if ($unit) {
            return response()->json([
                'status' => 'success',
                'message' => 'Unit retrieved successfully',
                'data' => $unit,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Unit not found',
                'data' => null,
            ], 404);
        }
    }
}
