<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateUser;
use App\Entities\UserDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        //
    }

    public function store(Request $request): JsonResponse
    {
        $user = CreateUser::run(UserDTO::from($request));
        return response()->json([
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function storeAdmin(Request $request): JsonResponse
    {
        $user = CreateUser::run(UserDTO::from($request), true);
        return response()->json([
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        //
    }

    public function update(Request $request, $id): JsonResponse
    {
        //
    }

    public function destroy($id): JsonResponse
    {
        //
    }
}
