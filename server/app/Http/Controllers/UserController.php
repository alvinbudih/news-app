<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        return response()->json($user);
    }

    public function create(Request $request)
    {
        $credentials = $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|unique:users",
            "password" => "required|max:255"
        ]);

        $credentials["password"] = bcrypt($credentials["password"]);

        $user = User::create($credentials);

        Log::create([
            "user_id" => $user->id,
            "description" => "Registered"
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken("LaravelAuthApp");

            Log::create([
                "user_id" => $user->id,
                "description" => "Logged In"
            ]);

            return response()->json(["token" => $token->plainTextToken]);
        }

        return response()->json(["message" => "Invalid Email or Password"], 400);
    }

    public function logout(Request $request)
    {
        Log::create([
            "user_id" => $request->user()->id,
            "description" => "Logged Out"
        ]);

        $request->user()->currentAccessToken()->delete();

        return response()->json(["message" => "Successfully Logged Out"]);
    }
}
