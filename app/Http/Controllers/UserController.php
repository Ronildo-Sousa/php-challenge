<?php

namespace App\Http\Controllers;

use App\Actions\Users\CreateUser;
use App\Entities\UserDTO;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $user = CreateUser::run(UserDTO::from($request));
        return response()->json([
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
