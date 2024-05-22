<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function updateNotificationSettings(Request $request)
    {
        $setting = Setting::whereIn('id', [1, 2, 3])->get();

        dd($setting);
        $user = auth()->user();
        $setting = $request->notificationRecommendation;

        return response()->json([
            'status' => 'success',
            'message' => 'Notification settings updated successfully',
            'data' => $user
        ], 200);
    }
}
