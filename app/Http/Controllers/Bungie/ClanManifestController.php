<?php

namespace App\Http\Controllers\Bungie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClanManifestController extends Controller
{
    protected $storage;

    public function __construct() {
        $this->storage = Storage::disk('bungie')->allFiles();
    }

    public function queryBannerManifest($query) {
        $results = array();
        if ($db = DB::connection('sqlite_banner')) {
            $result = $db->select($query);
            foreach ($results as $row)
            {
                $key = is_numeric($row[0]) ? sprintf('%u', $row[0] & 0xFFFFFFFF): $row[0];
                $results[$key] = json_decode($row[1]);
            }
            return $result;
        }
        return $results;
    }

    public function getSingleDefinition($tableName, $id) {

        $where = ' WHERE '.(is_numeric($id) ? 'id = '.$id.' OR id ='.($id-4294967296) : ' id = "'.$id.'"');
        $results = $this->queryBannerManifest('SELECT * FROM '.$tableName.$where);
        return $results;

        /**
        $tables = $this->getAllTables();

        $where = ' WHERE '.(is_numeric($id) ? 'id = '.$id.' OR id = '.($id-4294967296) : ' id = "'.$id.'"');
        $results = $this->queryManifest('SELECT * FROM '.$tableName.' WHERE id='.$id-4294967296);

        return isset($results[$id]) ? $results[$id] : false;
         */

    }
}
