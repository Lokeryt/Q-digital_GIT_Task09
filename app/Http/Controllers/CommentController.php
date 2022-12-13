<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $comments = $user->sentComments()->paginate(5);

        return view('UserComments', compact('comments'));
    }

    public function store($userId, CommentStoreRequest $request)
    {
        $request->validated();

        if ($request->parent_id) {
            $parentComment = Comment::findOrFail($request->parent_id);

            $receiver = User::findOrFail($parentComment->sender_id);
            Gate::authorize('reply-comment', $parentComment);
        } else {
            $receiver = User::findOrFail($userId);

            Gate::authorize('write-comment', $receiver->id);
        }

        Comment::create($request->all() + ['receiver_id' => $receiver->id, 'sender_id' => Auth::id()]);

        return Redirect::back();
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        Gate::authorize('delete-comment', $comment);

        $comment->delete();

        return Redirect::back();
    }
}
