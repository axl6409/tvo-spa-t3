<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $client = new Client([
          'base_uri' => 'https://www.bungie.net/PLatform',
          'timeout'  => 2.0,
        ]);
        $baseUrl = 'https://www.bungie.net/Platform';
        $headers = ['X-API-KEY' => env('BUNGIE_API_KEY')];
        $user = Auth::user();
        $request = new Request('GET',$baseUrl.'/Destiny2/'.$user->membership_type.'/Profile/'.$user->membership_id.'/?components=200', $headers);
        $promise = $client->requestAsync($request);
        
    }

    public function findUser()
    {
        $user = Auth::user();
        return $user;
    }
}
