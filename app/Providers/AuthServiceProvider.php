<?php

namespace App\Providers;

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

        Gate::define('write-comment', function (User $currentUser, $userId) {
            if ($userId != $currentUser->id) {
                return Response::allow();
            }
            Response::deny();
        });

        Gate::define('reply-comment', function (User $currentUser, Comment $comment) {
            if ($comment->sender_id != $currentUser->id) {
                return Response::allow();
            }
            Response::deny();
        });

        Gate::define('delete-comment', function (User $user, Comment $comment) {
            if (($comment->receiver_id == $user->id && $comment->parent_id == null) || $comment->sender_id == $user->id) {
                return Response::allow();
            }
            Response::deny();
        });
    }
}
