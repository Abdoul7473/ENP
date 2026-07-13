<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function index(Request $request){
        $permissions = Permission::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);
        $roles = Role::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->with('permissions')->paginate($request->page_size ?? 10);
        // dd($roles->permissions);
        return Inertia::render('user/roles', [
            "permissions" => $permissions,
            "roles" => $roles,
            "AllPermissions" => Permission::all()
        ]);
    }
    public function store(Request $request){
        $data = $this->validate($request, [
            'name' => 'required|string',
        ],[
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        ]);
        $permissions = $this->validate($request, [
            'permissions' => 'required'
        ],
        [
            'required' => 'Le champ :attribute est obligatoire.'
        ]);
        // dd($data, $permissions);
        $role = Role::create($data);
        $role->syncPermissions($permissions);
        // $role = Role::find($request->role_id);
        return redirect()->back()->with('success', 'Rôle créé avec succès!');
    }
    public function update (Request $request,$id){
        $role = Role::find($id);
        $role->name = $request->name ;
        // dd($request);
        $role->update();
        $role->syncPermissions($request->permissions);
        $roles = Role::with('users')->where('id',$request->id)->get()[0];
        // dd($roles->users);
        if ($roles->users != []){
            foreach ($roles->users as $key => $user) {
                $user->syncPermissions($request->permissions);
            }
        }
       
        return redirect()->back()->with('success', 'Rôle modifié avec succès!'); 
    }
    public function delete_permission(Request $request){
        $role = Role::find($request->id);
        $roles = Role::with('users')->where('id',$request->id)->get()[0];
        $role->revokePermissionTo($request->permission);
        foreach ($roles->users as $key => $user) {
            $user->revokePermissionTo($request->permission);
        }
        return redirect()->back()->with('success',"Permission retirée avec succès");
    }
    public function create_permission(Request $request){
        $role = Role::find($request->id);
        $roles = Role::with('users')->where('id',$request->id)->get()[0];
        $permissions = $this->validate($request, [
            'permissions' => 'required'
        ],);
        // dd($permissions);
        $role->givePermissionTo($permissions);
        foreach ($roles->users as $key => $user) {
            $user->givePermissionTo($request->permissions);
        }
        return redirect()->back()->with('success',"Permission attachée avec succès");
    }
    public function Not_found(){
        return Inertia::render('page');
    }
    public function destroy(Request $request, $id){
        $role = Role::find($id);
        $roles = Role::with('users','permissions')->where('id',$id)->get()[0];
        // dd($roles);
        foreach ($roles->permissions as $key => $permission) {
            $role->revokePermissionTo($permission);
            foreach ($roles->users as $key => $user) {
                // revokation de role au user
                $role_user = DB::table('model_has_roles')->where('role_id',$id)->get();
                $role_user->delete();
                $user->revokePermissionTo($permission);
            }
        }
        $role->delete();
        return redirect()->back()->with('success','Rôle supprimer avec succès');
    }
}
