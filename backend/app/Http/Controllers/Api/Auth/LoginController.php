<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if(! $user || ! Hash::check($password, $user->password))
        {
            throw ValidationException::withMessages([
                'email' => ['Not Mail or Not Password'],
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(compact('token'), 200);
    }
}
