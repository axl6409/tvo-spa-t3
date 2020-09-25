<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name'   =>  'required|unique:roles,name',
           'permission'     =>  'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
        return response()->json('Role created !', 200);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $role = Role::find($id);

        $permission = Permission::get();

        $rolePermission = DB::table("role_has_permission")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return response()->json([$role, $permission, $rolePermission], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return response()->json('Role updated !', 200);
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return response()->json('Role destroyed !', 200);
    }
}
