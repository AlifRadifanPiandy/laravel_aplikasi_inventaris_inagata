<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => 'Profile retrieved successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Profile not found',
            ], 404);
        }
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Invalid input',
            ], 400);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'status' => true,
            'data' => $user->id,
            'message' => 'Profile updated successfully',
        ], 200);
    }
}