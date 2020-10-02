<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CharacterController extends Controller
{
    protected $url = "https://www.bungie.net/Platform";
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }


    public function allCharacters()
    {
        $result = $this->doRequest($this->url.'/Destiny2/'.$this->user->membership_type.'/Profile/'.$this->user->membership_id.'/?components=200');
        return $result;
    }

    public function doRequest($path)
    {
        $request = Http::withHeaders([
            'X-API-KEY' => config('app.bungie_key')
        ])->get($path);
        return $request;
    }

    public function getCharacterStats ($id) {
        $result = $this->doRequest($this->url .'/Destiny2/'. $this->user->membership_type .'/Account/'. $this->user->membership_id.'/Character/'. $id .'/Stats/?components=100');
        $result = $result['Response'];
        return response()->json($result, 200);
    }
}
