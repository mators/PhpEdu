<?php


/**
 * Predstavlja sloj za dohvat podataka.
 */
abstract class DAL {

    private static $IDS_FILE = "data/ids.txt";

    protected static function deserialize($str, $keys) {
        $ret = [];
        $keyIndex = 0;
        foreach (explode(";", $str) as $item) {
            $ret[$keys[$keyIndex++]] = htmlspecialchars($item, ENT_QUOTES, "UTF-8");
        }
        return $ret;
    }

    protected static function incrementId($idName) {
        $ids = [];
        $lines = file_get_contents(self::$IDS_FILE);

        foreach (explode("\n", $lines) as $line) {
            $exploded = explode("=", $line);
            $ids[$exploded[0]] = intval($exploded[1]);
        }
        $retId = ++$ids[$idName];

        # Spremi promjenu u datoteku
        $newIDs = "";
        foreach ($ids as $id_name => $id) {
            $newIDs .= $id_name."=".$id."\n";
        }
        file_put_contents(self::$IDS_FILE, substr($newIDs, 0, -1));

        return $retId;
    }

    protected static function getByID($id, $file, $keys) {
        $lines = file_get_contents($file);
        foreach (explode("\n", $lines) as $line) {
            if (!empty($line)) {
                $data = self::deserialize($line, $keys);
                if ($data["id"] === $id) {
                    return $data;
                }
            }
        }
        return NULL;
    }

    protected static function getCollection($id, $idKey, $keys, $file) {
        $collection = [];
        $lines = file_get_contents($file);
        foreach (explode("\n", $lines) as $line) {
            if (!empty($line)) {
                $data = self::deserialize($line, $keys);
                if ($data[$idKey] == $id) {
                    array_push($collection, $data);
                }
            }
        }
        return $collection;
    }
}