<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function index()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $requests = Follower::with('to_user')->where(['from_user_id' => auth()->user()->id, 'accepted' => 0])->get();
        $active_user = "primary";
        return view('frontend.user.users', compact('users', 'active_user', 'requests'));
    }


    public function edit()
    {
        $user = User::find(auth()->user()->id);
        $active_profile = "primary";
        return view('frontend.user.profile', compact('user', 'active_profile'));
    }


    public function userInfo(Request $request)
    {
        $user = User::findOrFail($request->id);
        $posts = Post::where('user_id', $request->id)->limit(3)->get();
        $posts_counts = Post::where('user_id', $request->id)->count();
        $post_id = Post::where('user_id', $request->id)->get()->pluck('id');
        $likes_counts = Like::where('post_id', $post_id)->count();
        $is_follower = Follower::where('from_user_id', auth()->user()->id)->where('to_user_id', $request->id)->get();

        return view('frontend.user.user_info', compact('user', 'posts', 'posts_counts', 'likes_counts', 'is_follower'));
    }


    public function search(Request $request)
    {
//        $results = array();
        $item = $request->searchName;
        $data = User::where('first_name', 'LIKE', '%'.$item.'%')->orWhere('last_name', 'LIKE', '%'.$item.'%')
            ->take(5)
            ->get();

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user()->whereId($id)->first();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'avatar' => 'nullable|image|max:20000|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['birth_date'] = $request->birth_date;

        $fileName = "";
        if ($request->hasFile('avatar'))
        {
            if (auth()->user()->avatar != '') {
                if (File::exists('images/users/' . auth()->user()->avatar)) {
                    unlink('images/users/' . auth()->user()->avatar);
                }
            }
            $file = $request->file('avatar');
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/users/', $fileName);

        }

        if (strlen($fileName > 0))
        {
            $data['avatar'] = $fileName;
        }

        $update = $user->update($data);

        if ($update) {
            return redirect()->back()->with([
                'message' => 'Information updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }


}
