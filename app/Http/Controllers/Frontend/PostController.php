<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PostRequest;
use App\Models\Follower;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::withCount('likes')
            ->whereIn('user_id', auth()->user()->following()->where('accepted', 1)
            ->pluck('to_user_id'))
            ->orderBy('id', 'desc')
            ->paginate(9);
        $active_home = "primary";
        return view('frontend.home', compact('posts', 'active_home'));
    }


    public function userFriendPosts($id)
    {
//        $is_follower = Follower::where(['from_user_id' => auth()->user()->id, 'to_user_id' => $id, 'accepted' => 1])->get();
        if (policy(Post::class)->show_friend(auth()->user(), $id))
        {
            $posts = Post::withCount('likes')
                ->where('user_id', $id)
                ->paginate(9);
            return view('frontend.user.friend_posts', compact('posts'));
        }
        else {
            return redirect()->route('home');
        }
    }


    public function create()
    {
        return view('frontend.post.create');
    }


    public function store(PostRequest $request)
    {
        if ($request->hasFile('filename'))
        {
            $file = $request->file('filename');
            $fileName = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/posts', $fileName);
        }

        $data['image_path'] = $fileName;
        $data['body']  = $request->body;

        $post = auth()->user()->posts()->create($data);

        if ($post) {
            return redirect()->route('home')->with([
                'message' => 'Post created successfully',
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
        $post = Post::with('user')->findOrFail($id);
        $user = auth()->user();
        if ($user->can('show', $post))
        {
            $count = Like::where('post_id', $id)->count();
            $userLike = Like::where(['user_id'=> auth()->user()->id, 'post_id' => $id])->get();
            return view('frontend.post.show', compact('post', 'count', 'userLike'));
        }
        else
        {
            return redirect('Not found');
        }
    }


    public function edit($id)
    {
        $post = Post::whereId($id)->first();
//        if ($post->user_id == auth()->user()->id)
        if (auth()->user()->can('update', $post))
        {
            return view('frontend.post.edit', compact('post'));
        } else {
            return "Page Not Found 404";
        }
    }


    public function update(PostRequest $request, $id)
    {
        $post = Post::whereId($id)->first();

//        if ($post->user_id == auth()->user()->id)
        if (auth()->user()->can('update', $post))
        {
            $fileName = "";
            if ($request->hasFile('filename'))
            {
                if ($post->image_path != '') {
                    if (File::exists('images/posts/' . $post->image_path)) {
                        unlink('images/posts/' . $post->image_path);
                    }
                }

                $file = $request->file('filename');
                $fileName = time().$file->getClientOriginalName();
                $file->move(public_path().'/images/posts', $fileName);
            }

            $data['image_path'] = $fileName ? $fileName : $post->image_path;
            $data['body']  = $request->body;

            $post->update($data);

            if ($post) {
                return redirect()->route('home')->with([
                    'message' => 'Post updated successfully',
                    'alert-type' => 'success',
                ]);
            } else {
                return redirect()->back()->with([
                    'message' => 'Something was wrong',
                    'alert-type' => 'danger',
                ]);
            }
        }
    }


    public function destroy($id)
    {
        $post = Post::whereId($id)->first();
//        if ($post->user_id == auth()->user()->id)
        if (auth()->user()->can('delete', $post))
        {
            if ($post->delete())
            {
                return redirect()->route('home')->with([
                    'message' => 'Post Deleted Successfully',
                    'alert-type' => 'success'
                ]);
            } else {
                return redirect()->route('home')->with([
                    'message' => 'Something was wrong',
                    'alert-type' => 'danger'
                ]);
            }
        } else {
            return redirect()->route('home')->with([
                'message' => 'You not allow delete this Post',
                'alert-type' => 'danger'
            ]);
        }
    }
}
