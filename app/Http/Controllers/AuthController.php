<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function register(Request $request) {
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => "terjadi kesalahan",
                'data' => $validate->errors(),
            ]);
        }

        $data = $request->all();

        try {
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
    
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => "terjadi kesalahan",
                'data' => $e->getMessage(),
            ]);
        }
    }

    function login(Request $request) {
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            $user = Auth::user();
            $user['token'] = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "terjadi kesalahan"
            ]);
        }
    }
}
