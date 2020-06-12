<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use http\Client\Curl\User;
use App\User as Users;
use Illuminate\Http\Request;
use Laravel\Socialite\Two\BungieProvider;
use function MongoDB\BSON\toJSON;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        return tap($user)->update($request->only('name', 'email'));
    }
}
