<?php

namespace Laravelir\Ticketable\Console\Commands;

use Illuminate\Console\Command;

class InstallPackageCommand extends Command
{
    protected $signature = 'ticketable:install';

    protected $description = 'Install the ticketable Package';

    public function handle()
    {
        $this->line("\t... Welcome To Package Installer ...");


        // if (!empty(File::glob(database_path('migrations\*_create_packages_tables.php')))) {

        //     $list  = File::glob(database_path('migrations\*_create_packages_tables.php'));
        //     collect($list)->each(function ($item) {
        //         File::delete($item);
        //     });

        //     $this->publishMigration();
        // } else {
        //     $this->publishMigration();
        // }

        // if (!empty(File::glob(database_path('migrations\*_create_package_table.php')))) {
        //     $list  = File::glob(database_path('migrations\*_create_package_table.php'));
        //     collect($list)->each(function ($item) {
        //         File::delete($item);
        //         $this->warn("Deleted: " . $item);
        //     });
        //     $this->publishMigration();
        // } else {
        //     $this->publishMigration();
        // }

        $this->info("Package Successfully Installed.\n");
        $this->info("\t\tGood Luck.");
    }

    //       //config
    //       if (File::exists(config_path('package.php'))) {
    //         $confirm = $this->confirm("package.php already exist. Do you want to overwrite?");
    //         if ($confirm) {
    //             $this->publishConfig();
    //             $this->info("config overwrite finished");
    //         } else {
    //             $this->info("skipped config publish");
    //         }
    //     } else {
    //         $this->publishConfig();
    //         $this->info("config published");
    //     }

    //     //assets
    //     if (File::exists(public_path('package'))) {
    //         $confirm = $this->confirm("package directory already exist. Do you want to overwrite?");
    //         if ($confirm) {
    //             $this->publishAssets();
    //             $this->info("assets overwrite finished");
    //         } else {
    //             $this->info("skipped assets publish");
    //         }
    //     } else {
    //         $this->publishAssets();
    //         $this->info("assets published");
    //     }

    //     //migration
    //     if (File::exists(database_path("migrations/$migrationFile"))) {
    //         $confirm = $this->confirm("migration file already exist. Do you want to overwrite?");
    //         if ($confirm) {
    //             $this->publishMigration();
    //             $this->info("migration overwrite finished");
    //         } else {
    //             $this->info("skipped migration publish");
    //         }
    //     } else {
    //         $this->publishMigration();
    //         $this->info("migration published");
    //     }

    //     $this->call('migrate');
    // }

    private function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => "Laravelir\\Ticketable\\Providers\\TicketableServiceProvider",
            '--tag'      => 'package-config',
            '--force'    => true
        ]);
    }

    private function publishMigration()
    {
        $this->call('vendor:publish', [
            '--provider' => "Laravelir\\Ticketable\\Providers\\TicketableServiceProvider",
            '--tag'      => 'package-migrations',
            '--force'    => true
        ]);
    }

    // private function publishAssets()
    // {
    //     $this->call('vendor:publish', [
    //         '--provider' => "Laravelir\\Ticketable\\Providers\\TicketableServiceProvider",
    //         '--tag'      => 'package-assets',
    //         '--force'    => true
    //     ]);
    // }
}
