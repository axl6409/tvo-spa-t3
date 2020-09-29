<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ClanController extends Controller
{
    protected $url = "https://www.bungie.net/Platform/GroupV2/";
    protected $urlUser = "https://www.bungie.net/Platform/User/";
    protected $group;
    protected $clan;

    public function __construct() {
        $user = Auth::user();
        $result = $this->doRequest($this->url .'User/'. $user->membership_type .'/'. $user->membership_id .'/0/1/?components=0');
        $this->clan = $result['Response']['results']['0']['member']['groupId'];
    }

    public function doRequest($path) {
        $request = Http::withHeaders([
            'X-API-KEY' => config('app.bungie_key')
        ])->get($path);
        return $request;
    }

    public function infos() {
        $result = $this->doRequest($this->url . $this->clan .'/?components=100');
        $datas = $result['Response'];
        return response()->json($datas, 200);
    }

    public function members() {
        $result = $this->doRequest($this->url . $this->clan .'/Members/?components=100');
        $datas = $result['Response'];
        return response()->json($datas, 200);
    }

    public function getClanBanner() {
        $result = $this->doRequest($this->url . $this->clan .'/?components=100');
        $datas = $result['Response']['detail']['clanInfo']['clanBannerData'];
        return response()->json($datas, 200);
    }

    public function adminsAndFounder() {
        $result = $this->doRequest($this->url . $this->clan .'/AdminsAndFounder/');
        $datas = $result['Response'];
        return response()->json($datas, 200);
    }

    public function singleMember($id, $type) {
        $result = $this->doRequest($this->urlUser .'GetMembershipsById/'. $id . '/'. $type .'/?components=100,300');
        $datas = $result['Response'];
        return response()->json($datas, 200);
    }

}
