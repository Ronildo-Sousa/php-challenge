<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateUser;
use App\Entities\UserDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $user = CreateUser::run(UserDTO::from($request));
        return response()->json([
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function registerAdmin(Request $request): JsonResponse
    {
        $user = CreateUser::run(UserDTO::from($request), true);
        return response()->json([
            'user' => $user
        ], Response::HTTP_CREATED);
    }
}
