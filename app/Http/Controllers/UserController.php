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
    public function index() {
        return User::with('roles')->get();
    }

    public function register(RegisterUserRequest $userRequest) {
        $user = User::create([
            'name' => $userRequest->validated()['name'],
            'email' => $userRequest->validated()['email'],
            'password' => bcrypt($userRequest->validated()['password']),
        ]);

        // $response = [
        //     'id' => $user->id, 
        //     'name' => $user->name, 
        //     'email' => $user->email,
        //     'token' => $user->createToken(env('APP_SECRET', Str::random()))->plainTextToken
        // ];

        return $user;
    }

    public function login(LoginUserRequest $request) {
        $user = User::where('email', $request->validated()['email'])->with('roles')->first();
        $userRoles = $user->roles()->get()->map(fn($role) => $role->id);
        $token = '';

        if (!$user || !Hash::check($request->validated()['password'], $user->password)) {
            return [
                'message' => 'Invalid email or password'
            ];
        }

        if ($userRoles->some(fn($roleId) => $roleId === 1 || $roleId === 2)) {
            $token = $user->createToken(env('APP_SECRET', Str::random()), ['product_manipulate'])->plainTextToken;
        } else {
            $token = $user->createToken(env('APP_SECRET', Str::random()), [])->plainTextToken;
        }

        $response = [
            'id' => $user->id, 
            'name' => $user->name, 
            'email' => $user->email,
            'token' => $token
        ];

        return $response;
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out.'
        ];
    }
}
