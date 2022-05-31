<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(RegisterUserRequest $userRequest) {
        $user = User::create([
            'name' => $userRequest->validated()['name'],
            'email' => $userRequest->validated()['email'],
            'password' => bcrypt($userRequest->validated()['password']),
        ]);

        $response = [
            'id' => $user->id, 
            'name' => $user->name, 
            'email' => $user->email,
            'token' => $user->createToken(env('APP_SECRET', Str::random()))->plainTextToken
        ];

        return $response;
    }

    public function login(LoginUserRequest $request) {
        $response = [];
        $user = User::where('email', $request->validated()['email'])->first();

        if (!$user || !Hash::check($request->validated()['password'], $user->password)) {
            $response = [
                'message' => 'Invalid email or password'
            ];
        } else {
            $response = [
                'id' => $user->id, 
                'name' => $user->name, 
                'email' => $user->email,
                'token' => $user->createToken(env('APP_SECRET', Str::random()))->plainTextToken
            ];
        }

        return $response;
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out.'
        ];
    }
}
