<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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

        Gate::define('create-book', 'App\Policies\BookPolicy@createBook');

        Gate::define('delete-edit-book', 'App\Policies\BookPolicy@deleteEditBook');

        Gate::define('open-library', 'App\Policies\BookPolicy@openLibrary');
    }
}
