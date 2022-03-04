<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name'=>'Super admin','slug'=>'super-admin'],
            ['name'=>'Admin','slug'=>'admin'],
            ['name'=>'User','slug'=>'user']
        ]);
        DB::table('permissions')->insert([
            ['name' => 'Xem quyền', 'slug' => 'view-permission',],
            ['name' => 'Tạo mới quyền', 'slug' => 'create-permission',],
            ['name' => 'Sửa quyền','slug' => 'edit-permission', ],
            ['name' => 'Cập nhật quyền', 'slug' => 'update-permission'],
            ['name' => 'Xóa quyền', 'slug' => 'delete-permission',]
         ]);

        $role_id = Role::all()->pluck('id')->toArray();
        $per_id = Permission::all()->pluck('id')->toArray();
        for($i=0;$i<count($role_id);$i++){
            for($j=0;$j<count($per_id);$j++){
                DB::table('role_permission')->insert([
                    ['role_id'=>$role_id[$i],'permission_id'=>$per_id[$j]],
                ]);
            }
        }
    }
}
