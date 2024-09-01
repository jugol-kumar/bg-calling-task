<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserRequest;
use App\Http\Resources\Resource\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all users with roles
        $users = User::query()
            ->with('roles')
            ->simplePaginate();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $userRequest)
    {
        $data = $userRequest->validated();
        // upload user image in storage
        if($userRequest->hasFile('image')) $data['image'] = $userRequest->file('image')->store('/upload');

        $user = User::create($data);
        // find the role and assign to user
        $role = Role::query()->findOrFail($userRequest['role']);
        if($user && $role) $user->assignRole($role->name); // if user create and get the role then assign role to user
        return response()->json('User Created Successfully Done...');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->image && Storage::exists($user->image)) Storage::delete($user->image);
        $user->delete();
        return response('User Deleted Successfully Done...');
    }
}
