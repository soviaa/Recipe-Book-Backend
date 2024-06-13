<?php

namespace App\Http\Controllers\MachineLearning;

use App\Http\Controllers\Controller;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class GeminiTestController extends Controller
{
    public function index()
    {
        $result = Gemini::geminiPro()->generateContent('How to make a cup of coffee? Give Detailed Steps.');

        return response()->json([
            'status' => 'success',
            'message' => 'Content generated successfully',
            'data' => $result->text(),
        ], 200);
    }

    public function imageIdentifier(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $image = $request->file('image');

        $result = Gemini::geminiProVision()
            ->generateContent([
                'Please provide the detailed recipe of given image (Ingredients, Instruction and Tips). If the given image is not of food or eatable item then respond with the given image is not of food or eatable item.',
                new Blob(
                    mimeType: MimeType::IMAGE_JPEG,
                    data: base64_encode(
                        file_get_contents($image->getRealPath())
                    )
                ),
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Image identified successfully',
            'data' => $result->text(),
        ], 200);
    }
}
