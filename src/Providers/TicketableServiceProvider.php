<?php

namespace Laravelir\Ticketable\Providers;

use App\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravelir\Ticketable\Facades\Ticketable;
use Laravelir\Ticketable\Console\Commands\InstallPackageCommand;
use Laravelir\Ticketable\Console\Commands\InstallTicketableCommand;

class TicketableServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../../config/ticketable.php", 'ticketable');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->registerFacades();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerCommands();
        // $this->registerRoutes();
        // $this->registerBladeDirectives();
        // $this->publishStubs();
        // $this->registerLivewireComponents();
    }

    private function registerFacades()
    {
        $this->app->bind('ticketable', function ($app) {
            return new Ticketable();
        });
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                InstallPackageCommand::class,
            ]);
        }
    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../config/ticketable.php' => config_path('ticketable.php')
        ], 'package-config');
    }


    // public function registerTranslations()
    // {
    //     $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'package');

    //     $this->publishes([
    //         __DIR__ . '/../../resources/lang' => resource_path('lang/laravelir/package'),
    //     ], 'package-langs');
    // }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/ticketable.php', 'package-routes');
        });
    }

    private function routeConfiguration()
    {
        return [
            'prefix' => config('ticketable.routes.prefix'),
            'middleware' => config('ticketable.routes.middleware'),
            'as' => 'ticketable.'
        ];
    }

    protected function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../database/migrations/create_ticketable_tables.stub' => database_path() . "/migrations/{$timestamp}_create_ticketable_tables.php",
        ], 'package-migrations');
    }

    // protected function registerBladeDirectives()
    // {
    //     Blade::directive('format', function ($expression) {
    // return "<?php echo ($expression)->format('m/d/Y H:i') ?/>";
    //     });

    //     Blade::directive('config', function ($key) {
    //         return "<?php echo config('package.' . $key); ?/>";
    //     });
    // }

    // protected function registerMiddleware(Kernel $kernel, Router $router)
    // {
    //     // global
    //     $kernel->pushMiddleware(CapitalizeTitle::class);

    //     // route middleware
    //     // $router = $this->app->make(Router::class);
    //     $router->aliasMiddleware('capitalize', CapitalizeTitle::class);

    //     // group
    //     $router->pushMiddlewareToGroup('web', CapitalizeTitle::class);
    // }

    // public function registerLivewireComponents()
    // {
    // Livewire::component('test', Test::class);
    // }
}
