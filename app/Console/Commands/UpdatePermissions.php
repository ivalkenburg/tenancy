<?php

namespace App\Console\Commands;

use App\Helpers\Multitenancy\Models\Tenant;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\PermissionRegistrar;

class UpdatePermissions extends Command
{
    protected $signature = 'app:update-permissions';
    protected $description = 'Update permissions and default roles';

    /**
     * @return int
     */
    public function handle()
    {
        Tenant::forgetCurrent();

        $this->updatePermissions();
        $this->createRoles();
        $this->syncPermissionsWithRoles();
        $this->clearCaches();

        return 0;
    }

    /**
     * @return void
     */
    public function updatePermissions()
    {
        $this->info('Updating permissions');

        $intended = collect(config('app.default_permissions.permissions'))->keys();
        $current = DB::table(config('permission.table_names.permissions'))->pluck('name');

        $intended->diff($current)->each(function ($name) {
            $permission = Permission::create(compact('name'));
            $this->line(" Added {$permission->name}");
        });

        $current->diff($intended)->each(function ($name) {
            Permission::findByName($name)->delete();
            $this->line(" Removed {$name}");
        });
    }

    /**
     * @return void
     */
    protected function createRoles()
    {
        $this->info('Creating roles');

        foreach (config('app.default_permissions.roles') as $name => $description) {
            try {
                Role::create([
                    'name' => $name,
                    'description' => $description,
                    'locked' => true,
                    'tenant_id' => null
                ]);

                $this->line(" Created {$name}");
            } catch (RoleAlreadyExists $exception) {
                // TODO: check if description changed and change it if necessary
                continue;
            }
        }
    }

    /**
     * @return void
     */
    protected function syncPermissionsWithRoles()
    {
        $this->info('Syncing permissions with roles');

        $roles = collect(config('app.default_permissions.roles'))->keys();
        $permissions = collect(config('app.default_permissions.permissions'));

        $roles->each(function ($role) use ($permissions) {
            $rolePermissions = $permissions->filter(fn($value, $key) => in_array($role, $value))->keys();
            Role::findByName($role)->syncPermissions($rolePermissions);

            $this->line(" Synced {$rolePermissions->count()} permission(s) with role {$role}");
        });
    }

    /**
     * @return void
     */
    protected function clearCaches()
    {
        if (Tenant::isMultitenancyEnabled()) {
            Tenant::cursor()->each(function (Tenant $tenant) {
                $tenant->execute(fn() => app(PermissionRegistrar::class)->forgetCachedPermissions());
            });
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
