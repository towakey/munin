<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;


class AuthController extends Controller
{
    //
    /**
     * ログイン
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        
        if (! $user || ! Hash::check($password, $user->password)) {
            return response()->json(['message' => 'failed'], 401);
        }
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(compact('token'), 200);
        // if (Auth::attempt($request->only(["email", "password"]))) {
        //         // レスポンスを返す
        //     return response()->json(['message' => 'success'], 200);
        // } else {
        //     // エラーレスポンスを返す
        //     return response()->json(['message' => 'failed'], 401);
        // }
    }

    /**
     * ログアウト
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        // ログアウトする
        Auth::logout();
        // レスポンスを返す
        return response()->json(['message' => 'Logged out'], 200);
    }
}
