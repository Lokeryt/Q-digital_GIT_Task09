<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = (new User())->getUsers()->paginate(10);

        return view('users', compact('users'));
    }

    public function profile(Request $request, $id = null)
    {
        if (Auth::check() && (!$id || $id == Auth::id())) {
            $userId = Auth::id();
        }
        else {
            $userId = $id;
        }

        $user = User::findOrFail($userId);
        $comments = $user->receivedComments()
            ->where('parent_id', null)
            ->withTrashed()
            ->get();
        $count = $comments->count();

        if ($request->all) {
            return response()->json([
                'success' => true,
                'html' => view('comments', compact('comments', 'user', 'count'))->render(),
                'comments' => $comments,
            ]);
        }

        $comments = $comments->take(5);

        return view('Profile', compact('comments', 'user', 'count'));
    }
}
