<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use App\Drink;
use App\Food;
use App\Room;
use App\User;
use App\Venue;
use App\Activity;
use App\Businessday;
use App\Payrol;
use App\Branch;
use App\Title;
use App\RoomType;
use App\DrinkType;
use App\CrateSize;
use App\Department;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::model('drink',Drink::class);
        Route::model('room',Room::class);
        Route::model('venue',Venue::class);
        Route::model('food',Food::class);
        Route::model('member',User::class);
        Route::model('department',Department::class);
        Route::model('activity',Activity::class);
        Route::model('branch',Branch::class);

        Route::model('title',Title::class);
        Route::model('room_type',RoomType::class);
        Route::model('drink_type',DrinkType::class);
        Route::model('crate_size',CrateSize::class);

        Route::model('payroll',Payroll::class);
        Route::model('businessday',Businessday::class);

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
