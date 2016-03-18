<?php

namespace app\models;

use app\oipa\model\Model;
use app\oipa\model\Repository;


class PhotoRepository extends Repository {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new PhotoRepository();
        }
        return self::$instance;
    }

    public function get($id) {
        return parent::get($id);
    }

    public function getByUser($userId) {
        return parent::getAll(["user_id" => $userId]);
    }

    public function getByGalleryId($galleryId) {
        return parent::getAll(["gallery_id" => $galleryId]);
    }

    public function save(Photo $photo) {
        return parent::save([
            "user_id" => $photo->getUserID(),
            "gallery_id" => $photo->getGalleryID(),
            "name" => $photo->getName(),
            "description" => $photo->getDescription(),
            "image" => $photo->getPhoto()
        ]);
    }

    public function update($id, Model $model) {
        // TODO: Implement update() method.
    }

    public function delete($id) {
        // TODO: Implement delete() method.
    }

    protected function getTable() {
        return "photos";
    }

    protected function modelFromData($data) {
        return new Photo(
            $data->name,
            $data->description,
            $data->user_id,
            $data->gallery_id,
            $data->image,
            $data->id
        );
    }

}