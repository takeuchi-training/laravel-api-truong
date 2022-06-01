<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function __construct() {
    }

    public function sendVerificationEmail(Request $request) {
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return [
                'message' => 'Verification link has been sent.'
            ];
        }

        return [
            'message' => 'Already verified.'
        ];
    }

    public function verify(EmailVerificationRequest $request) {
        // if (!$request->hasValidSignature()) {
        //     return response()->json(["message" => "Invalid/Expired url provided."], 401);
        // }
        
        // $user = User::find($request->id);
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));

            return response()->json([
                'message' => 'Email has been verified.',
                200
            ]);
        }

        return [
            'message' => 'Already verified.'
        ];
    }
}
