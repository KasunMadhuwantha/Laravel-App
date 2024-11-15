<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|integer|min:1',
            'mobile_number' => 'required|string|max:15|unique:users,mobile_number',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Creating a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'age' => $request->age,
            'mobile_number' => $request->mobile_number,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function getAllUsers()
    {
        // Fetch all users from the database
        $users = User::all();

        // Return the users as a JSON response
        return response()->json(['users' => $users], 200);
    }

    public function getUserById($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the user as a JSON response
        return response()->json(['user' => $user], 200);
    }

    //get users by age
    public function getUsersByAge($age)
    {
        // Find the user by age
        $users = User::where('age', $age)->get();

        // Check if user exists
        if (!$users) {
            return response()->json(['message' => 'Users not found'], 404);
        }

        // Return the user as a JSON response
        return response()->json(['users' => $users], 200);
    }


}
