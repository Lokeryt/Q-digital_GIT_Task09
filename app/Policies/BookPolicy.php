<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function createBook(User $currentUser, User $owner)
    {
        if ($currentUser->id == $owner->id) {
            return Response::allow();
        }
        return Response::deny();
    }

    public function deleteEditBook(User $currentUser, Book $book)
    {
        if ($currentUser->id == $book->user_id) {
            return Response::allow();
        }
        return Response::deny();
    }

    public function openLibrary(User $currentUser, User $user)
    {
        if ($currentUser->id == $user->id || $currentUser->hasLibraryAccess($user)) {
            return Response::allow();
        }
        return Response::deny();
    }
}
