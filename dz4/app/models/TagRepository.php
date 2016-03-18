<?php

namespace app\models;


use app\oipa\model\Repository;

class TagRepository extends Repository {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new TagRepository();
        }
        return self::$instance;
    }

    public function get($id) {
        return parent::get($id);
    }

    public function getByPhoto($photoId) {
        return parent::getAll(["photo_id" => $photoId]);
    }

    public function save($photoId, $tag) {
        parent::save(["tag" => $tag]);
    }

    public function saveAll($photoId, $tags) {
        foreach ($tags as $tag) {
            $this->save($photoId, $tag);
        }
    }

    protected function getTable() {
        return "tags";
    }

    protected function modelFromData($data) {
        return $data;
    }

}