<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(Request $request)//: \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::guard('sanctum')->user();

            if($user->tokens()) $user->tokens()->delete();
            $user->token =  $user->createToken('MyApp')->plainTextToken;
            $user->image = Storage::url($user->image);

            $user->load('roles.permissions');
            $user->can = $user->roles->flatMap->permissions->pluck('name')->unique()->toArray();

            return response()->json([
                "message" => "User Login Successfully Done...",
                "data" => $user
            ]);
        }
        else{
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email'
        ]);

        $user = User::query()->findOrFail(Auth::id());
        if($name = $request->input('name')){
            $user->name = $name;
        }

        $email = $request->input('email');
        if ($email !== null) {
            $user->email = $email;
        }
        if($request->hasFile('image')) $user->image = $request->file('image')->store('/profile');

        $user->save();
        return response()->json([
            'message' => 'Your Profile has been Updated...'
        ]);
    }


    /**
     * @throws ValidationException
     */
    public function updatePassword(Request $request)
    {
        $user = User::query()->findOrFail(Auth::id());
        $hashedPassword = $user->password;

        $request->validate([
            'current_password' => 'required',
            'new_password'=> 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',
        ]);

        if (Hash::check($request->input('current_password'), $hashedPassword)) {
            if (!Hash::check($request->input("new_password"), $hashedPassword)) {
                $user->update([
                    'password' => Hash::make($request->input("new_password"))
                ]);
                return response()->json(['message' => "New Password Updated.."]);
            } else {
                throw ValidationException::withMessages(['new_password' => "New Password Can Not Be Same As Same Password"]);
            }
        } else {
            throw ValidationException::withMessages(['current_password' => "Current Password Not Match"]);
        }
    }


    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        Auth::guard('web')->logout();
//        Auth::guard('admin')->logout();
        return response()->json([
            "message" => "User Logout Successfully Done...",
        ]);
    }
}

