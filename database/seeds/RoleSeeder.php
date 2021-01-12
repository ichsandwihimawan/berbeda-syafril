<?php

use Illuminate\Database\Seeder;
use App\Models\Authentication\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_employee = new Role();
	    $role_employee->name = 'admin';
	    $role_employee->display_name = 'Administrator';
	    $role_employee->description = 'Administrator';
	    $role_employee->save();

	    $role_employee = new Role();
	    $role_employee->name = 'user';
	    $role_employee->display_name = 'User';
	    $role_employee->description = 'User';
	    $role_employee->save();

	    $role_employee = new Role();
	    $role_employee->name = 'manager';
	    $role_employee->display_name = 'Manajemen';
	    $role_employee->description = 'Manajemen';
	    $role_employee->save();
    }
}
