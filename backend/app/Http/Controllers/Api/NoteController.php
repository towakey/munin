<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $note=DB::table('notes')->where("user_id",Auth::id())->latest()->get();
        return $note;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $title=$request->title;
        $contents=$request->contents;
        $type=$request->type;
        $user_id=$request->user()->id;
        $secret=$request->secret;
        // $user_id=Auth::id();
        // $user_id=$request->user_id;

        // Note::create([
        //     'title'=>$title,
        //     'contents'=>$contents,
        //     'type'=>$type,
        //     'user_id'=>$user_id
        // ]);

// $note->Note::create(['title'=>'titl','contents'=>'$contents','type'=>'$type','user_id'=>'$user_id']);

        if(Note::create([
            'title'=>$title,
            'contents'=>$contents,
            'type'=>$type,
            'secret'=>$secret,
            'user_id'=>$user_id,
        ]))
        {
            return response()->json('success', 200);
        }
        else
        {
            return response()->json('create failed', 401);
        }
        // return response()->json($user_id, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
        if(Note::where('id',$request->id)->update([
            'title'=>$request->title,
            'contents'=>$request->contents,
            'type'=>$request->type,
            'secret'=>$request->secret,
        ]))
        {
            return response()->json('success', 200);
        }
        else
        {
            return response()->json('create failed', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Note $note)
    {
        //
        $delete_id=$request->delete_id;
        // Note::destroy($delete_id);
        if(Note::destroy($delete_id)){
            return response()->json('success', 200);
        }
        else
        {
            return response()->json('create failed', 401);
        }
    }
}
