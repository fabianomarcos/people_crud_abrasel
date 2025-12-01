<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * Se você tiver modelos e policies, mapeie aqui:
     * 'App\Models\Model' => 'App\Policies\ModelPolicy',
     */
    protected $policies = [
        // 'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Aqui você pode definir Gates globais, por exemplo:
        // Gate::define('update-post', fn ($user, $post) => $user->id === $post->user_id);
    }
}
