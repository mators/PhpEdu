<?php

namespace app\models;

use app\oipa\model\Repository;


class GalleryRepository extends Repository {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new GalleryRepository();
        }
        return self::$instance;
    }

    /**
     * @param $id
     * @return Gallery|null
     */
    public function get($id) {
        return parent::get($id);
    }

    public function getByUser($userId) {
        return parent::getAll(["user_id" => $userId]);
    }

    public function save(Gallery $gallery) {
        return parent::save([
            "user_id" => $gallery->getUserID(),
            "name" => $gallery->getName(),
            "description" => $gallery->getDescription()
        ]);
    }

    public function update(Gallery $gallery) {
        return parent::update($gallery->getGalleryID(), [
            "user_id" => $gallery->getUserID(),
            "name" => $gallery->getName(),
            "description" => $gallery->getDescription()
        ]);
    }

    public function delete($id) {
        parent::delete($id);
    }

    public function getTable() {
        return "galleries";
    }

    protected function modelFromData($data) {
        return new Gallery(
            $data->description,
            $data->name,
            $data->user_id,
            $data->id
        );
    }

}