<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json(compact('user'), 200);
    }

    public function update(Request $request, User $user)
    {
        if(User::where('id',$request->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]))
        {
            return response()->json('success', 200);
        }
        else
        {
            return response()->json('create failed', 401);
        }
    }
}
