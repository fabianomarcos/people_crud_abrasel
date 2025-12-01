<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Infra\Persistence\Eloquent\Repositories\PersonRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepositoryEloquent::class);
    }
}
