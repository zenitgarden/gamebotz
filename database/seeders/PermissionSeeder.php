<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorities = config('permission.authorities');
       $listPermission = [];
       $adminPermission = [];
       $authorPermission = [];

       foreach ($authorities  as $label => $permission) {
           foreach($permission as $p){
            $listPermission[] = [
                'name'=> $p,
                'guard_name'=>'web',
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s')
            ];
            //admin
            $adminPermission[] = $p;
            
            //author
            if(in_array($label,['manage_posts'])){
                $authorPermission[] = $p;
            }
        }     
    }
        //Insert Permission

        Permission::insert($listPermission);

        //Insert role

        $admin = Role::create([
            'name'=> 'Admin',
            'guard_name'=>'web',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);

        $author = Role::create([
            'name'=> 'Author',
            'guard_name'=>'web',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);

        // Role > permission
        $admin->givePermissionTo($adminPermission);
        $author->givePermissionTo($authorPermission);


        User::find(1)->assignRole("Admin");
    }
}
