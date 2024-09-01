<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Nette\Schema\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthorizationController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index() //: \Illuminate\Http\JsonResponse
    {



        if(!auth()->user()->hasRole(env('APP_SUPPERADMIN_ROLE'))){
            if(!auth()->user()->can('authorization.create') || !auth()->user()->can('authorization.edit')){
                abort(401);
            }
        }


        $groupPermissions = Permission::with('roles')->get()->groupBy('module_name'); //all();
        $allPermissions = Permission::with(["roles"])->get();
        return response()->json([
            'groupPermissions' => $groupPermissions,
            'allPermissions' => $allPermissions
        ]);

    }

    public function store(): \Illuminate\Http\JsonResponse
    {
        // check this user is valid for this action
        if(!auth()->user()->hasRole(env('APP_SUPPERADMIN_ROLE'))){
            if(!auth()->user()->can('authorization.create')){
                abort(401);
            }
        }
        // validate data for create role with custom validation error message
        Request::validate([
            'roleName' => 'required|unique:roles,name',
            'selectedPermissions' => 'required'
        ], [
            'roleName.required' => 'Please Given Role Name',
            'selectedPermissions.required' => 'Please Select Minimum One Permission'
        ]);

        // create role with this entered name
        $role = Role::create(['name' => Request::input('roleName')]);

        // sync selected permissions with this created role
        foreach (Request::input('selectedPermissions') as $permission) {
            $role->givePermissionTo($permission);
        };

        return response()->json("Role Create Successfully Done....");

    }

    public function getAllRoles()
    {

        // get all created roles name and id
        $roles = Role::query()->select(['id', 'name'])->get();
        return response()->json($roles);
    }

    public function editRole($id): \Illuminate\Http\JsonResponse
    {
        $data = Role::with(['permissions'])->find($id);
        return response()->json($data);
    }

    /**
     * @throws \Exception
     */
    public function updateRole($id): \Illuminate\Http\JsonResponse
    {
        if(!auth()->user()->hasRole(env('APP_SUPPERADMIN_ROLE'))){
            if(!auth()->user()->can('authorization.edit')){
                abort(401);
            }
        }
        // validate role name with ignore
        Request::validate([
            "roleName" => ['required', Rule::unique('roles', 'name')->ignore($id)],
            'selectedPermissions' => 'required'
        ]);

        $role = Role::query()->findOrFail($id);

        // if role not get then throw error
        if ($role) {
            $role->update(['name' => Request::input('roleName')]);
            $role->syncPermissions(Request::input('selectedPermissions'));
            return response()->json("Role Updated Successfully Done....");
        }
        // throw execution for invalid role id
        throw new \Exception('Role Not Found... Invalid Role Id...', 404);
    }


}
