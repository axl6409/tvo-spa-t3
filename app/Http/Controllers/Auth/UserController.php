<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function current(Request $request)
    {
        return response()->json($request->user());
    }

    public function all()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function setUserAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->assignRole('admin');
    }


}
