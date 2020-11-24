<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\Frontend\CommentRequest;
use App\Models\Post;

class CommentController extends Controller
{

    public function store(CommentRequest $request)
    {
        $post = Post::with('user')->find($request->post_id);
        if (policy(Comment::class)->create(auth()->user(), $post))
        {
            $comment = new Comment();
            $comment->post_id = $request->post_id;
            $comment->user_id = auth()->user()->id;
            $comment->comment = $request->comment;

            $comment->save();
            return redirect()->back()->with([
                'message' => 'Comment add successfully',
                'alert-type' => 'success',
            ]);
        }
        else
        {
            return redirect('Not found');
        }
    }

    public function destroy($id)
    {
        $comment = Comment::whereId($id)->first();
//        if (auth()->user()->id == $comment->user_id)
        if (auth()->user()->can('delete', $comment))
        {
            $comment->delete();
            return redirect()->back()->with([
                'message' => 'Comment deleted successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'You not authorized to delete this comment',
                'alert-type' => 'danger',
            ]);
        }
    }
}
