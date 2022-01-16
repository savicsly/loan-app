<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Users retrieved successfully',
            'users' => UserResource::collection(User::paginate(10)),
        ]);
    }
}
