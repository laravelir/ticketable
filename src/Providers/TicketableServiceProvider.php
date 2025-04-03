<?php

namespace Laravelir\Ticketable\Providers;

use Illuminate\Support\ServiceProvider;
use Laravelir\Ticketable\Facades\Ticketable;
use Laravelir\Ticketable\Console\Commands\InstallPackageCommand;

class TicketableServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../../config/ticketable.php", 'ticketable');
        $this->registerFacades();
    }

    public function boot()
    {
        $this->registerCommands();
        $this->publishConfig();
        $this->publishMigrations();
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
        ], 'ticketable-config');
    }

    protected function publishMigrations()
    {
        $timestamp = date('Y_m_d_His', time());
        $this->publishes([
            __DIR__ . '/../../database/migrations/create_ticketable_table.stub.php' => database_path() . "/migrations/{$timestamp}_create_ticketable_table.php",
        ], 'ticketable-migrations');
    }
}
