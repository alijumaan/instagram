<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function index()
    {
        //
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
        return view('frontend.post.show', compact('post'));
    }


    public function edit($id)
    {
        $post = Post::whereId($id)->first();
        if ($post->user_id == auth()->user()->id)
        {
            return view('frontend.post.edit', compact('post'));
        } else {
            return "Page Not Found 404";
        }
    }


    public function update(PostRequest $request, $id)
    {
        $post = Post::whereId($id)->first();

        if ($post->user_id == auth()->user()->id)
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
        if ($post->user_id == auth()->user()->id)
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
