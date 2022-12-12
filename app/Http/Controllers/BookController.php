<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\User;
use App\Models\UserLibraryAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    public function getUserBooks($id)
    {
        $owner = User::findOrFail($id);
        Gate::authorize('open-library', $owner);

        $books = $owner->ownedBooks()->paginate(5);

        return view('books', compact('books', 'owner'));
    }

    public function getBook($id)
    {
        $book = Book::findOrFail($id);

        return view('book', compact('book'));
    }

    public function store($userId, StoreBookRequest $request)
    {
        $request->validated();

        $owner = User::findOrFail($userId);
        Gate::authorize('create-book', $owner);

        Book::create($request->all() + ['user_id' => Auth::id()]);

        return Redirect::back();
    }

    public function edit($id, StoreBookRequest $request)
    {
        $request->validated();

        $book = Book::findOrFail($id);

        Gate::authorize('delete-edit-book', $book);

        $book->update($request->all());

        return Redirect::back();
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);

        Gate::authorize('delete-edit-book', $book);

        $book->delete();

        return Redirect::back();
    }

    public function changeLibraryAccess($id)
    {
        $user = User::findOrFail($id);

        $access = $user->hasLibraryAccess(Auth::user());

        if ($access) {
            $access->delete();
        } else {
            UserLibraryAccess::create(['owner_id' => Auth::id(), 'user_id' => $user->id]);
        }

        return Redirect::back();
    }

    public function shareBook($id)
    {
        $book = Book::findOrFail($id);

        Gate::authorize('delete-edit-book', $book);

        if ($book->code) {
            $code = $book->code;
        } else {
            $code = bin2hex(random_bytes(15));
            $book->update(['code' => $code]);
        }

        $url = url()->route('Book', $book->id)."?code=$code";

        return Redirect::back()->with('Success', "Ссылка для доступа: $url");
    }
}
