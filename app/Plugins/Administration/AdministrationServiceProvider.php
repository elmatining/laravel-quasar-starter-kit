<?php namespace App\Plugins\Administration;

use App\Plugins\Administration\Console\AuthPermissionCommand;
use App\Plugins\Administration\Console\AuthRoleCommand;
use Illuminate\Support\ServiceProvider;

class AdministrationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton('command.auth.role', function () {
            return new AuthRoleCommand();
        });

        $this->app->singleton('command.auth.permission', function () {
            return new AuthPermissionCommand();
        });

        $this->commands([
            'command.auth.role',
            'command.auth.permission'
        ]);
    }
}