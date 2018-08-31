<?php namespace App\Plugins\Administration\Console;

use App\Models\User;
use App\Plugins\Administration\Models\Role;
use Illuminate\Console\Command;

class AuthRoleCommand extends Command
{
    protected $signature = 'auth:assign {--R|remove}';

    protected $description = 'Assign new role to user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $userId = $this->ask('What is the user id?');

        $role = $this->choice('What role to assign?', Role::pluck('name')->toArray(), 0);

        if ( $user = User::find($userId) ) {
            if ( $is_remove = $this->option('remove') ) {
                if ( $user->hasRole(strtolower($role)) ) {
                    $user->removeRole(strtolower($role));
                    $this->warn('Role ' . strtolower($role) . 'has been revoked.');
                } else {
                    $this->warn("User does not have {$role} role.");
                }
            } else {
                if ( $user->hasRole(strtolower($role)) ) {
                    $this->warn('Role ' . strtolower($role) . ' has already been assigned.');
                } else {
                    $user->assignRole(strtolower($role));
                    $this->info('Role ' . strtolower($role) . 'has been granted to user with id ' . $userId);
                }
            }


        } else {
            $this->warn("User with id {$userId} not found.");
        }
    }
}