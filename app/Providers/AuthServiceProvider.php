<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use \Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('write-comment', 'App\Policies\CommentPolicy@writeComment');

        Gate::define('reply-comment', 'App\Policies\CommentPolicy@replyComment');

        Gate::define('delete-comment', 'App\Policies\CommentPolicy@deleteComment');

        Gate::define('create-book', function (User $currentUser, User $owner) {
            if ($currentUser->id == $owner->id) {
                return Response::allow();
            }
            return Response::deny();
        });

        Gate::define('delete-edit-book', function (User $currentUser, Book $book) {
            if ($currentUser->id == $book->user_id) {
                return Response::allow();
            }
            return Response::deny();
        });

        Gate::define('open-library', function (User $currentUser, User $user) {
            if ($currentUser->id == $user->id || $currentUser->hasLibraryAccess($user)) {
                return Response::allow();
            }
            return Response::deny();
        });
    }
}
