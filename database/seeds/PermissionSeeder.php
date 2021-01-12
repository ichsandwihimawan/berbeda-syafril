<?php

use Illuminate\Database\Seeder;
use App\Models\Authentication\Role;
use App\Models\Authentication\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_admin = Role::where('name', 'admin')->first();
	    $role_user  = Role::where('name', 'user')->first();
    	
    	// create permissions
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sys_permission_role')->truncate();
        DB::table('sys_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    	
    	$permissions = [
    		// ------------- DASHBOARD ---------------
    		[
				'name'         => 'dashboard',
				'display_name' => 'Dashboard',
				'action'       => ['view'],
    		],
    		// ------------- MASTER ---------------
            [
                'name'         => 'master-akun-induk',
                'display_name' => 'Akun Induk',
                'action'       => ['view', 'add', 'edit', 'delete'],
            ],
    		[
				'name'         => 'master-order',
				'display_name' => 'OrderBy',
				'action'       => ['view', 'add', 'edit', 'delete'],
    		],
            [
                'name'         => 'master-transorder',
                'display_name' => 'Trans Order',
                'action'       => ['view', 'add', 'edit', 'delete'],
            ],
    		// ------------- Konfigurasi ---------------
    		[
				'name'         => 'konfigurasi-users',
				'display_name' => 'Manajemen Pengguna',
				'action'       => ['view', 'add', 'edit', 'delete'],
    		],
    		[
				'name'         => 'konfigurasi-roles',
				'display_name' => 'Hak Akses',
				'action'       => ['view', 'add', 'edit', 'delete'],
    		],
    	];

    	foreach ($permissions as $row) {
    		foreach ($row['action'] as $key => $val) {
    			$temp = [
					'name'         => $row['name'].'-'.$val,
					'display_name' => $row['display_name'].' '.ucfirst($val)
    			];	
    			$perms = Permission::create($temp);

    			$role_admin->attachPermission($perms);
    			$role_user->attachPermission($perms);
    		}
    	}
    }
}
