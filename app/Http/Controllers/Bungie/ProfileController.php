<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    protected $url = "https://www.bungie.net/Platform";
    protected $user;
    protected $characters;

    public function __construct()
    {
        $this->user = Auth::user();
    }


    public function index()
    {
        $user = Auth::user();
        $result = $this->doRequest($this->url.'/Destiny2/'.$user->membership_type.'/Profile/'.$user->membership_id.'/?components=200');
        $this->characters = $result['Response']['characters']['data'];
        return $this->characters;
    }

    /**
     * Get Characters from the user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function characters(Request $request)
    {
        $request = $this->getUserInfos();
        return response()->json($request);
    }

    public function getUserInfos()
    {
        $user = Auth::user();
        $request = $this->doRequest($this->url .'/Destiny2/'. $user->membership_type .'/Profile/'. $user->membership_id .'/?components=100');
        return $request;
    }

    public function doRequest($path)
    {
        $request = Http::withHeaders([
            'X-API-KEY' => config('app.bungie_key')
        ])->get($path);
        return $request;
    }

    public function characterInfos($characters)
    {
        foreach ($characters as $character) {
            return $character = $character['characterId'];
        }
    }
}
