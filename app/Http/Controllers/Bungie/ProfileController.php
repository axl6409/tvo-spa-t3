<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    protected $url = 'https://www.bungie.net/Platform';
    protected $url2 = 'https://www.bungie.net/';


    public function index()
        {
            $user = Auth::user();
            $url = $this->url.'/Destiny2/'.$user->membership_type.'/Profile/'.$user->membership_id.'/?components=200';
            $response = $this->checkManifest();
            return $response;
        }

        public function doRequest($path)
        {
            $request = Http::withHeaders([
              'X-API-KEY' => config('app.bungie_key')
            ])->get($path);
            return $request;
        }

        public function checkManifest() {
            $result = $this->doRequest($this->url.'/Destiny2/Manifest/');
            $result->json($result, true);

            $onlineManifest = $result['Response']['mobileWorldContentPaths']['fr'];
            $onlineManifestName = str_replace('/common/destiny2_content/sqlite/fr/', '', $onlineManifest);
            $onlineManifestNameZip = str_replace('.content', '.zip', $onlineManifestName);

            $localManifest = Storage::disk('bungie')->allFiles();
            $localManifestName = strval($localManifest[0]);

            if ($onlineManifestNameZip != $localManifestName) {
                $return = [$onlineManifestNameZip, $localManifestName];
                return $return;
            }

            return 'Manifest Up To Date !';
        }

        public function updateManifest($url, $name)
        {
            $path = storage_path('app/bungie/');
            $file_name = pathinfo(storage_path('app/bungie/'.$name), PATHINFO_FILENAME);
            $file_path = fopen($path.$file_name.'.zip', 'w');
            $client = new Client();
            $headers = [
              'X-API-KEY' => config('app.bungie_key'),
              'sink'      => $file_path
            ];
            $client->get($this->url2.$url, $headers);
        }


}
