<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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

    private $id = [
        'topic',
        'level',
        'content',
        'lesson',
        'exercise',
        'exerciseData',
        'translation',
        'course',
//        'courseLesson',
        'jobStatus',
        'user',
        'role',
        'appLocale',
        'localeGroup',
    ];

    private $slug = [
        'language',
        'courseLesson'
    ];

    private $uuid = [
        'key'
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        collect($this->id)->map(function ($name) {
            Route::pattern($name, '[0-9]+');
        });
        collect($this->slug)->map(function ($name) {
            Route::pattern($name, '[a-z0-9-]+');
        });
        collect($this->uuid)->map(function ($name) {
            Route::pattern($name, '[a-z0-9-]+');
        });

        parent::boot();
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

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
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
