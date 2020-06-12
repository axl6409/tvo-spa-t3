<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OAuthProvider;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        config([
            'services.github.redirect' => route('oauth.callback', 'github'),
            'services.bungie.redirect' => route('oauth.callback', 'bungie'),
        ]);
    }

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

    public function allCaracters($userId)
    {
        $userMbId = User::find($userId);
        $user = Socialite::driver('bungie')->getUserCaracters($userMbId->membership_id);
        dd($user);

    }
}
