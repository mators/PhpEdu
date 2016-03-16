<?php

namespace app\models;

use app\oipa\model\Model;


/**
 * Predstavlja sliku
 */
class Photo implements Model {

    /**
     * Identifikator slike.
     * @var int
     */
    private $pictureID;

    /**
     * Naslov slike.
     * @var string
     */
    private $title;

    /**
     * Opis slike.
     * @var string
     */
    private $description;

    /**
     * Identifikator korisnika.
     * @var int
     */
    private $userID;

    /**
     * Identifikator galerije.
     * @var int
     */
    private $galleryID;

    /**
     * Stvara sliku.
     * @param $pictureID int
     * @param $title string
     * @param $description string
     * @param $userID int
     * @param $galleryID int
     */
    public function __construct($pictureID, $title, $description, $userID, $galleryID) {
        $this->pictureID = $pictureID;
        $this->title = $title;
        $this->description = $description;
        $this->userID = $userID;
        $this->galleryID = $galleryID;
    }

    /**
     * @return mixed
     */
    public function getPictureID() {
        return $this->pictureID;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getGalleryID() {
        return $this->galleryID;
    }

    public function equals(Model $model) {
        // TODO: Implement equals() method.
    }

    public function serialize() {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized) {
        // TODO: Implement unserialize() method.
    }

}