<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SQLite3;
use ZipArchive;

class ProfileController extends Controller
{

    protected $url = 'https://www.bungie.net/Platform';


    public function index()
    {
        $user = Auth::user();
        $result = $this->url.'/Destiny2/'.$user->membership_type.'/Profile/'.$user->membership_id.'/?components=200';
        $result->json($result, true);
        return $result;
    }

}
