<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function getSetting(){
        $setting = Setting::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Setting retrieved successfully',
            'data' => $setting
        ]);
    }
}

