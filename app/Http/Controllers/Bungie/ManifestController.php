<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SQLite3;
use ZipArchive;

class ManifestController extends Controller
{
    protected $url = 'https://www.bungie.net/Platform';
    protected $url2 = 'https://www.bungie.net/';
    protected $manifestUrl = "";
    protected $originalManifestName = "";
    protected $manifestNameToZip = "";
    protected $originalNameWithoutExt = "";
    protected $localManifest = "";
    protected $localNameWithoutExt = "";
    protected $tables = [];
    protected $storage;

    protected $test;

    public function __construct()
    {
        $this->storage = Storage::disk('bungie')->allFiles();
        $this->localManifest = $this->storage[0];
    }

    public function initManifest()
    {
        $file = Storage::disk('bungie')->allFiles();
        $manifest = pathinfo(database_path('/sqlite/'.$file[0]), PATHINFO_BASENAME);
        return $manifest;
    }

    public function checkManifest()
    {
        $result = $this->doRequest($this->url.'/Destiny2/Manifest/');
        $result->json($result, true);

        $this->manifestUrl = $result['Response']['mobileWorldContentPaths']['fr'];
        $this->originalManifestName = str_replace('/common/destiny2_content/sqlite/fr/', '', $this->manifestUrl);
        $this->manifestNameToZip = str_replace('.content', '.zip', $this->originalManifestName);
        $this->originalNameWithoutExt = pathinfo(database_path('/sqlite/'.$this->originalManifestName), PATHINFO_FILENAME);

        $storage = Storage::disk('bungie')->allFiles();

        if (empty($storage)) {

          $this->getManifest($this->manifestUrl);
          $this->extractManifest($this->manifestNameToZip);
          $this->localManifest = Storage::disk('bungie')->get($this->originalNameWithoutExt.'.sqlite');
          return 'Manifest Uploaded !';

        }

        $localNameWithoutExt = pathinfo(database_path('/sqlite/'.$storage[0]), PATHINFO_FILENAME);
        if ($this->originalNameWithoutExt != $localNameWithoutExt) {

          $this->updateManifest($this->manifestUrl);
          $this->extractManifest($this->manifestNameToZip);
          $this->localManifest = Storage::disk('bungie')->get($this->originalNameWithoutExt.'.sqlite');
          return 'Manifest Updated !';

        }

        return 'Manifest Up To Date !';

    }

    public function doRequest($path)
    {
      $request = Http::withHeaders([
        'X-API-KEY' => config('app.bungie_key')
      ])->get($path);
      return $request;
    }

    public function getManifest($url)
    {
        $path = database_path('/sqlite/');
        $file_path = fopen($path.$this->manifestNameToZip, 'w');

        $client = new Client();
        $headers = [
          'X-API-KEY' => config('app.bungie_key'),
          'sink'      => $file_path
        ];
        $client->get($this->url2.$url, $headers);
    }

    public function extractManifest($file)
    {
        $zip = new ZipArchive();
        $zipfile = database_path('/sqlite/'.$file);

        if ($zip->open($zipfile) === true) {
          $zip->extractTo(database_path('/sqlite/'));
          $zip->close();
        }

        $this->localNameWithoutExt = pathinfo(database_path('/sqlite/'.$this->localManifest), PATHINFO_FILENAME);
        rename(database_path('/sqlite/'.$this->originalManifestName), database_path('/sqlite/'.$this->originalNameWithoutExt.'.sqlite'));
    }

    public function updateManifest($url)
    {
        $allFiles = Storage::disk('bungie')->allFiles();
        $file_path = fopen($this->manifestNameToZip, 'w');

        Storage::disk('bungie')->delete($allFiles);

        $client = new Client();
        $headers = [
          'X-API-KEY' => config('app.bungie_key'),
          'sink'      => $file_path
        ];
        $client->get($this->url2.$url, $headers);

        if ($db = new SQLite3($this->localManifest)) {
            $result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");

            while($row = $result->fetchArray()) {
                $result2 = $db->query("PRAGMA table_info(".$row['name'].")");

                while($row2 = $result2->fetchArray()) {
                    $this->tables = $row2[1];
                }
            $this->tables[$row['name']] = $this->tables;
            }
        }

        return $this->tables;
    }

    public function queryManifest($query) {

        $results = array();
        if ($db = DB::connection('sqlite')) {
            $result = $db->select($query);
            foreach ($results as $row)
            {
                $key = is_numeric($row[0]) ? sprintf('%u', $row[0] & 0xFFFFFFFF) : $row[0];
                $results[$key] = json_decode($row[1]);
            }

            return $result;
        }

        return $results;
    }


    public function getAllTables()
    {
        return $this->queryManifest('SELECT name FROM sqlite_master WHERE type=\'table\' ORDER BY name');
    }

    public function getDefinition($tableName) {
        return $this->queryManifest('SELECT * FROM '.$tableName);
    }

    public function getSingleDefinition($tableName, $id) {

        $tables = $this->getAllTables();
        $key = $tables->{$tableName}[0];
        $where = ' WHERE '.(is_numeric($id) ? $key.'='.$id.' OR '.$key.'='.($id-4294967296) : $key.'="'.$id.'"');
        $results = $this->queryManifest('SELECT * FROM '.$tableName.$where);

        return isset($results[$id]) ? $results[$id] : false;

    }
}
