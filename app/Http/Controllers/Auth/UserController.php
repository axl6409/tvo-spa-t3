<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserUpdateRequest;
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

    public function setUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->role_id = $request->input('role');
            $user->save();
        }
        return response()->json('Success !', 200);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete($id);
        return response()->json('User Deleted', 200);
    }

    public function single($id) {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }
}
