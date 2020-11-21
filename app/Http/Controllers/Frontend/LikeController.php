<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $is_like = Like::where(['user_id'=> auth()->user()->id, 'post_id'=> $request->post_id]);
        if ( $is_like->count() == 0 )
        {
            $like = new Like();
            $like['post_id'] = $request->post_id;
            $like['user_id'] = auth()->user()->id;
            $like->save();

//          return redirect()->back()->with(['message' => 'You Like successfully ', 'alert-type' => 'success']);

            $count = Like::where('post_id', $request->post_id)->count();
            return response()->json(['count' => $count, 'id' => $like->id]);
        }

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($post_id)
    {
        $like = Like::where(['user_id' => auth()->user()->id, 'post_id' => $post_id]);
        $like->delete();
//      return redirect()->route('home')->with(['message' => 'Unliked', 'alert-type' => 'success']);
        $count = Like::where('post_id', $post_id)->count();
        return response()->json(['count' => $count]);

    }
}
