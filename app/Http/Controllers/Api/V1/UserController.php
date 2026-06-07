<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginUserRequest;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(StoreUserRequest $request) : JsonResponse {
        $user = User::create($request->all());

        return response()->json([
            'success'   => true,
            'message'   => 'user created successfully',
            'data'      => [
                'id'    => $user->id,
                'name'  => $user->name,
            ],
        ]);
    }

    public function login(LoginUserRequest $request) {
        if(!auth()->attempt($request->credentials())) {
            return response()->json([
                'success'   => false,
                'message'   => 'invalid email and/or password',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('access-token', ['*'], now()->addHour())->plainTextToken; // expire after 1 hour

        return response()->json([
            'success'   => true,
            'message'   => 'user logged in successfully',
            'data'      => [
                'accessToken'  => $token,
                'user_id'      => $user->id,
                'name'         => $user->name,
                'role'         => $user->role,
            ]
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'user logged out successfully', 
            'data'      => [],
        ]);
    }
}
