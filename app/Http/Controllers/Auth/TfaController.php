<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

class TfaController extends Controller
{
    /**
     * Reset the user's password
     */
    public function twoFactorGenerate(Request $request): JsonResponse
    {
        $user = User::where('id', auth()->user()->id)->first();
        $check2fa = $user->is_tfa;
        if ($check2fa) {
            return response()->json([
                'status' => 'failure',
                'message' => '2FA already enabled',
                'data' => null,
            ]);
        } else {
            $google2fa = new Google2FA();
            $companyName = env('APP_NAME');
            $companyEmail = $user->email;
            $secretKey = $google2fa->generateSecretKey();

            // Save the secret key to the user's record
            $user->tfa_secret = encrypt($secretKey);
            $user->save();

            $qrCodeUrl = $google2fa->getQRCodeUrl(
                $companyName,
                $companyEmail,
                $secretKey
            );
            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);

            $qrCode = $writer->writeString($qrCodeUrl);

            // Define the file path
            $filePath = 'qrcodes/'.Str::random(10).'.svg';

            // Check if the 'qrcodes' directory exists and create it if it doesn't
            if (! Storage::disk('public')->exists('qrcodes')) {
                Storage::disk('public')->makeDirectory('qrcodes');
            }

            // Save the QR code to a file in the public directory
            Storage::disk('public')->put($filePath, $qrCode);

            return response()->json([
                'status' => 'success',
                'message' => '2FA generated successfully',
                'data' => [
                    'qr_code_url' => url(Storage::url($filePath)),
                    'secret_key' => $secretKey,
                ],
            ], 200);
        }
    }

    /**
     * This method is responsible for verifying the 2FA code provided by the user.
     * It first validates the request data, ensuring that the OTP is a 6-digit number and the user ID is provided.
     * Then, it creates a new instance of the Google2FA class.
     * It retrieves the user record that matches the provided user ID and decrypts the user's tfa_secret.
     * It ensures that the OTP and the secret key are strings.
     * It verifies the OTP against the secret key using the Google2FA class.
     * If the OTP is valid, it creates a new token for the user and sets the token's expiry time to 1 hour from now.
     * If the user's is_tfa field is false, it sets it to true and saves the user record.
     * Finally, it returns a JSON response indicating that the 2FA code was verified successfully and provides the token.
     * If the OTP is not valid, it returns a JSON response with an error message.
     *
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function twoFactorVerify(Request $request): JsonResponse
    {
        // Validate the request data
        $request->validate([
            'otp' => 'required|regex:/^[0-9]{6}$/', // OTP must be a 6-digit number
        ]);

        // Create a new instance of the Google2FA class
        $google2fa = new Google2FA();

        // Retrieve the user record that matches the provided user ID and decrypt the user's tfa_secret
        $secretKey = User::where('id', auth()->user()->id)->first()->tfa_secret;
        $user = User::where('id', auth()->user()->id)->first();

        // Ensure that the secret key is a string
        $secretKey = (string) decrypt($secretKey);

        // Ensure that the OTP is a string
        $otp = (string) $request->otp;

        // Verify the OTP against the secret key using the Google2FA class
        $isValid = $google2fa->verifyKey($secretKey, $otp);

        if ($isValid) {
            // OTP is valid. Generate the token.
            $tokenResult = $user->createToken('api-token');
            $token = $tokenResult->accessToken;
            $token->expires_at = now()->addHours(1); // Token expires in 1 hour
            $token->save();

            $plainTextToken = $tokenResult->plainTextToken;
            if (! $user->is_tfa) {
                $user->is_tfa = true;
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => '2FA enabled for the user',
                    'token' => $plainTextToken,
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => '2FA code verified successfully',
                'token' => $plainTextToken,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Invalid 2FA code',
                'data' => null,
            ], 400);
        }
    }

    /**
     * This method is responsible for disabling two-factor authentication (2FA) for a user.
     * It first validates the request data, ensuring that the user ID is provided.
     * Then, it retrieves the user record that matches the provided user ID.
     * If the user is found, it sets the user's tfa_secret to null and is_tfa to false, and saves the user record.
     * Finally, it returns a JSON response indicating that 2FA was disabled successfully.
     */
    public function twoFactorDisable(Request $request): JsonResponse
    {
        // Validate the request data
        $request->validate([
            'user' => 'required|integer',
        ]);

        // Retrieve the user record that matches the provided user ID
        $user = User::where('id', $request->user)->first();

        // Set the user's tfa_secret to null and is_tfa to false
        $user->tfa_secret = null;
        $user->is_tfa = false;

        // Save the user record
        $user->save();

        // Return a JSON response indicating that 2FA was disabled successfully
        return response()->json([
            'status' => 'success',
            'message' => '2FA disabled successfully',
            'data' => null,
        ], 200);
    }
}
