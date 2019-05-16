<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
      //  Schema::defaultStringLength(191);

      Blade::component('components.admin_panel', 'admin_panel');
      Blade::component('components.view_panel', 'view_panel');
      Blade::component('components.nav_bar', 'nav_bar');
    }
}
