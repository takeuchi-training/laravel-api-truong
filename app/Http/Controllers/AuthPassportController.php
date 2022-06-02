<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthPassportController extends Controller
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

        return $user;
    }

    public function login(LoginUserRequest $request) {
        $user = User::where('email', $request->validated()['email'])->with('roles')->first();
        $userRoles = $user->roles()->get()->map(fn($role) => $role->id);

        if (!$user || !Hash::check($request->validated()['password'], $user->password)) {
            return [
                'message' => 'Invalid email or password'
            ];
        }
        
        if ($userRoles->some(fn($roleId) => $roleId === 1)) {
            $tokenResult = $user->createToken(env('APP_SECRET', Str::random()), ['all']);
        } else if ($userRoles->some(fn($roleId) => $roleId === 1 || $roleId === 2)) {
            $tokenResult = $user->createToken(env('APP_SECRET', Str::random()), ['manipulate-product']);
        } else {
            $tokenResult = $user->createToken(env('APP_SECRET', Str::random()));
        }

        $token = $tokenResult->token;

        if (!!$request['remember_me']) {
            $token->expires_at = now()->addWeeks(1);
        }

        $token->save();

        $response = [
            'id' => $user->id, 
            'name' => $user->name, 
            'email' => $user->email,
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'scopes' => $token->scopes
        ];

        return $response;
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();

        return [
            'message' => 'Logged out.'
        ];
    }
}
