<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function role_manage(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.role.index', [
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    function permission_store(Request $request){
        Permission::create(['name' => $request->permission_name]);
        return back();
    }

    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);

        return back();
    }

    function delete_role($id){
        $role = Role::find($id);
        DB::table('role_has_permissions')->where('role_id', $id)->delete();
        Role::find($id)->delete();
        return back();
    }

    function edit_role($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('admin.role.edit_role', [
            'permissions'=>$permissions,
            'role'=>$role,
        ]);
    }

    function update_role(Request $request, $id){
        $role = Role::find($id);
        $role->syncPermissions($request->permission);
        return back();
    }

    function assign_role(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role);

        return back();
    }

    function remove_role($id){
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        return back();
    }
}