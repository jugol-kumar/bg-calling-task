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
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
    public function store(UserRequest $userRequest): \Illuminate\Http\JsonResponse
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
    public function show(User $user): UserResource
    {
        return UserResource::make($user->load('roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $userRequest, User $user): \Illuminate\Http\JsonResponse
    {
        $data = $userRequest->validated();
        // if has new image then delete image and upload new image
        if($userRequest->hasFile('image')){
            if($user->image && Storage::exists($user->image)) Storage::delete($user->image);
            $data['image'] = $userRequest->file('image')->store('/upload');
        }

        $user->update($data);
        $role = Role::query()->findOrFail($userRequest['role']);
        if($role) $user->syncRoles($role->name); // if user create and get the role then assign role to user
        return response()->json('User Updated Successfully Done...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
    {
        if($user->image && Storage::exists($user->image)) Storage::delete($user->image);
        $user->delete();
        return response('User Deleted Successfully Done...');
    }
}
