<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BaseRepositoryEloquent;
use Modules\Configuration\Repositories\Role\RoleRepository;
use Modules\Configuration\Repositories\User\UserRepository;
use Modules\Configuration\Repositories\Module\ModuleRepository;
use Modules\Configuration\Repositories\Role\RoleRepositoryEloquent;
use Modules\Configuration\Repositories\User\UserRepositoryEloquent;
use Modules\Configuration\Repositories\Module\ModuleRepositoryEloquent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Validator::extend('mod10000', function ($attribute, $value, $parameters, $validator) {
            return $value % 10000 == 0;
  });
  Validator::extend('mod5', function ($attribute, $value, $parameters, $validator) {
    return $value % 5 == 0;
});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            BaseRepository::class,
            BaseRepositoryEloquent::class
        );
        $this->app->singleton(
            UserRepository::class,
            UserRepositoryEloquent::class
        );
        $this->app->singleton(
            RoleRepository::class,
            RoleRepositoryEloquent::class
        );
        $this->app->singleton(
            ModuleRepository::class,
            ModuleRepositoryEloquent::class
        );
    }
}
