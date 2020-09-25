<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'bungie_id'  =>  '24453991',
            'membership_id'  =>  '4611686018497957943',
            'membership_type'   =>  '3',
            'name'  =>  '▯DarkMorgoth▯',
            'nickname'  =>   'DarkMorgoth',
            'avatar'    =>  '/img/profile/avatars/Destiny26.jpg'
        ]);

        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
