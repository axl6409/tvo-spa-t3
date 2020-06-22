<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ManifestController extends Controller
{
    public $bungieUrl = 'https://www.bungie.net/';
    public $bungieManifest = 'Platform/Destiny2/Manifest/';

    public function getManifest()
    {
        $client = new Client([
           'base_uri' => $this->bungieUrl,
           'X-API-KEY' => env('BUNGIE_API_KEY')
        ]);
        $promise = $client->get($this->bungieManifest);

        return response()->json($promise);

    }
}
