<?php

namespace App\Http\Controllers\Mobile;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MobileLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MobileAuthController extends Controller
{
    public function login(MobileLoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = User::where('email', $request->input('email'))->firstOrFail();

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}