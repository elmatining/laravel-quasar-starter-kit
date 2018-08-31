<?php namespace App\Plugins\Administration\Console;

use App\Plugins\Administration\Models\Permission;
use App\Plugins\Administration\Models\Role;
use Illuminate\Console\Command;

class AuthPermissionCommand extends Command
{
    protected $signature = 'auth:permission {name} {--R|remove}';

    protected $description = 'Create auth permission for a model';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $permissions = $this->generatePermissions();

        if ( $is_remove = $this->option('remove') ) {
            if ( Permission::where('name', 'LIKE', "%{$this->getNameArgument()}")->delete() ) {
                $this->warn('Permissions ' . implode(', ', $permissions) . 'deleted');
            } else {
                $this->warn("No permissions for {$this->getNameArgument()} found.");
            }
        } else {
            foreach ( $permissions as $permission ) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
            }

            $this->info('Permissions ' . implode(', ', $permissions) . ' created.');
        }

        if ( $role = Role::whereName('administrator')->first() ) {
            $role->syncPermissions(Permission::all());

            $this->info('Administrator permissions updated.');
        } else {
            $role = Role::create(['name' => 'administrator', 'guard_name' => 'api']);

            $this->info('Administrator role created.');

            $role->syncPermissions(Permission::all());

            $this->info('Administrator permissions updated.');
        }
    }

    private function generatePermissions()
    {
        $abilities = ['view', 'add', 'edit', 'delete'];
        $name = $this->getNameArgument();

        return array_map(function ( $val ) use ( $name ) {
            return "{$val}_{$name}";
        }, $abilities);
    }

    private function getNameArgument()
    {
        return strtolower(str_plural($this->argument('name')));
    }
}