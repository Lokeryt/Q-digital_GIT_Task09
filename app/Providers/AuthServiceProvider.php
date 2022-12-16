<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use \Illuminate\Auth\Access\Response;
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
    }
}
