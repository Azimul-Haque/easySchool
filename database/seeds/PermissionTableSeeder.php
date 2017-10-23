<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'role-list',
        		'display_name' => 'Display Role Listing',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-create',
        		'display_name' => 'Create Role',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'role-edit',
        		'display_name' => 'Edit Role',
        		'description' => 'Edit Role'
        	],
        	[
        		'name' => 'role-delete',
        		'display_name' => 'Delete Role',
        		'description' => 'Delete Role'
        	],
        	[
        		'name' => 'student-list',
        		'display_name' => 'Display Student Listing',
        		'description' => 'See only Listing Of Student'
        	],
        	[
        		'name' => 'student-create',
        		'display_name' => 'Create Student',
        		'description' => 'Create New Student'
        	],
        	[
        		'name' => 'student-edit',
        		'display_name' => 'Edit Student',
        		'description' => 'Edit Student'
        	],
        	[
        		'name' => 'student-delete',
        		'display_name' => 'Delete Student',
        		'description' => 'Delete Student'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
