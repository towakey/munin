<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Hash;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $whereArray[]=["user_id",Auth::id()];
        $whereArray[]=["secret","public"];
        // Log::info($request->selectType);
        // $note=DB::table('notes')->where([
        //     ["user_id",Auth::id()],
        //     ["secret","public"]
        // ])->latest()->get();
        if(count($request->selectType)===0){
            // $note=DB::table('notes')->where($whereArray)->orwhere('type','note')->latest()->get();
            $note=null;
        }else{
            $note=DB::table('notes')->where($whereArray)->Where(function($query) use ($request){
                $query->where('type',$request->selectType[0]);
                for($i=1;$i<count($request->selectType);$i++){
                    $query->orWhere('type',$request->selectType[$i]);
                }
            })->latest()->get();
        }
        return $note;
    }

    public function secret(Request $request)
    {
        //
        $user = User::where('id',Auth::id())->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Log::info("false");
            return response()->json(['message' => "message"], 401);
        }else{
            $note=DB::table('notes')->where([
                ["user_id",Auth::id()],
                ["secret","private"]
            ])->latest()->get();
            // Log::info("true");
            return $note;
        }

    }

    public function getItem(Request $request)
    {
        return Note::where('id', $request->id)->first();
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
        $node_from=$request->node_from;
        $node_to=$request->node_to;
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
            'node_from'=>$node_from,
            'node_to'=>$node_to,
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
            'node_from'=>$request->node_from,
            'node_to'=>$request->node_to,
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
