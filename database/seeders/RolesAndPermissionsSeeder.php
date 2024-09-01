<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all = [
            [
                'module' => "Dashboard",
                'permissions' => [
                    'dashboard.show',
                    'dashboard.edit',
                ],
                'name' => [
                    'Show Dashboard',
                    'Edit Dashboard',
                ]
            ],
            [
                'module' => "User",
                'permissions' => [
                    'user.show',
                    'user.index',
                    'user.create',
                    'user.edit',
                    'user.delete',
                    'user.loginas',
                ],
                'name' => [
                    'Show User',
                    'List User',
                    'Create User',
                    'Edit User',
                    'Delete User',
                    'Login As User',
                ]
            ],
            [
                'module' => "Authorizations",
                'permissions' => [
                    'authorization.index',
                    'authorization.create',
                    'authorization.edit',
                    'authorization.delete'
                ],
                'name' => [
                    'List Authorization',
                    'Create Authorization',
                    'Edit Authorization',
                    'Delete Authorization'
                ]
            ],
            [
                'module' => "Settings",
                'permissions' => [
                    'settings.show'
                ],
                'name' => [
                    'Show Settings',
                ]
            ]
        ];

        foreach ($all as $item) {
            $module = Module::updateOrCreate([
                'module_name' => $item['module'],
                'slug' => Str::slug($item['module']),
            ]);

            foreach ($item['permissions'] as $key => $permission){
                Permission::updateOrCreate([
                    'name' => $permission,
                    'show_name' => $item['name'][$key],
                    'module_name' => $item['module'],
                    'guard_name' => 'sanctum',
                    'module_id' => $module->id,
                ]);
            }
        };

        Role::create(['name' => 'Administrator', 'guard_name' => 'sanctum', 'is_delete' => false]);


        User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt(12345678),
        ])->assignRole('Administrator');
    }
}

