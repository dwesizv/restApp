<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller {

    function __construct() {
        $this->middleware('auth:api')->only(['juan', 'protected']);
        $this->middleware('user')->only(['user']);
    }
    
    function login(Request $request) {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = Auth::user(); //$request->user();
        $tokenResult = $user->createToken('Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ], 200);
    }

    function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out']);
    }

    function protected() {
        return response()->json(['user' => Auth::user()], 200);
    }
    
    function register(Request $request) {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        } catch(\Exception $e) {
            return response()->json(['message' => 'User not created'], 418);
        }
        return response()->json(['message' => 'User created'], 201);
    }

    function user() {
        $user = Auth::user();
        //if($user->email == 'juan@juan.es') {
        return response()->json(['user' => Auth::user()], 200);
        //}
        //return response()->json(['user' => 'no'], 200);
    }
}