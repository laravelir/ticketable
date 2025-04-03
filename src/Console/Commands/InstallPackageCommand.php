<?php

namespace Laravelir\Ticketable\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallPackageCommand extends Command
{
    protected $signature = 'ticketable:install';

    protected $description = 'Install the ticketable Package';

    public function handle()
    {
        $this->line("\t... Welcome To Package Installer ...");

        if (!empty(File::glob(database_path('migrations\*_create_ticketable_table.php')))) {

            $list  = File::glob(database_path('migrations\*_create_ticketable_table.php'));
            collect($list)->each(function ($item) {
                File::delete($item);
            });

            $this->publishMigration();
        } else {
            $this->publishMigration();
        }

        //config
        if (File::exists(config_path('ticketable.php'))) {
            $confirm = $this->confirm("ticketable.php already exist. Do you want to overwrite?");
            if ($confirm) {
                $this->publishConfig();
                $this->info("config overwrite finished");
            } else {
                $this->info("skipped config publish");
            }
        } else {
            $this->publishConfig();
            $this->info("config published");
        }


        $this->info("Package Successfully Installed.\n");
        $this->info("\t\tGood Luck.");
    }

    private function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => "Laravelir\\Ticketable\\Providers\\TicketableServiceProvider",
            '--tag'      => 'ticketable-config',
            '--force'    => true
        ]);
    }

    private function publishMigration()
    {
        $this->call('vendor:publish', [
            '--provider' => "Laravelir\\Ticketable\\Providers\\TicketableServiceProvider",
            '--tag'      => 'ticketable-migrations',
            '--force'    => true
        ]);
    }
}
