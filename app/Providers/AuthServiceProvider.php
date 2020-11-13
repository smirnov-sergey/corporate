<?php

namespace App\Providers;

use App\Article;
use App\Policies\ArticlePolicy;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('VIEW_ADMIN', function (User $user) {
            return $user->canDo('VIEW_ADMIN', false);
        });

        $gate->define('VIEW_ADMIN_ARTICLES', function (User $user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES', false);
        });

        $gate->define('EDIT_USERS', function (User $user) {
            return $user->canDo('EDIT_USERS', false);
        });
    }
}
