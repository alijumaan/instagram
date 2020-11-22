<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    public function index()
    {
        $follow_requests = Follower::with('from_user')
            ->where('to_user_id', auth()->user()->id)
            ->where('accepted', 0)
            ->get();
        $followers = Follower::with('from_user', 'to_user')
            ->where(['to_user_id' => auth()->user()->id, 'accepted' => 1])
            ->orWhereRaw('from_user_id = ? AND accepted = ?', [auth()->user()->id, 1])
            ->get();
        $active_follow = "primary";
        return view('frontend.user.followers', compact('follow_requests', 'active_follow', 'followers'));

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $follower = new Follower();
        $follower->from_user_id  = auth()->user()->id;
        $follower->to_user_id = $request->user_id;
        $follower->accepted = 0;
        $follower->save();

        if ($follower) {
            return redirect()->back()->with([
                'message' => 'Request successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
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
        $follow = Follower::find($id);
        $follow->accepted = 1;
        $follow->save();
        return redirect()->back()->with([
            'message' => 'Accept as friend',
            'alert-type' => 'success',
        ]);

    }


    public function destroy($id)
    {
        $request = Follower::where('id', $id);
        $request->delete();
        return redirect()->back()->with([
            'message' => 'Request Canceled',
            'alert-type' => 'success',
        ]);

    }
}
