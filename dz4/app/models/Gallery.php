<?php

namespace app\models;

use app\oipa\model\Model;


/**
 * Predstavlja galeriju slika u aplikaciji.
 */
class Gallery implements Model {

    /**
     * Identifikator galerije.
     * @var int
     */
    private $galleryID;

    /**
     * Opis galerije.
     * @var string
     */
    private $description;

    /**
     * Naslov galerije.
     * @var string
     */
    private $title;

    /**
     * Identifikator korisnika.
     * @var int
     */
    private $userID;

    /**
     * Stvara novu galeriju
     *
     * @param $galleryID int
     * @param $description string
     * @param $title string
     * @param $userID string
     */
    public function __construct($galleryID, $description, $title, $userID) {
        $this->galleryID = $galleryID;
        $this->description = $description;
        $this->title = $title;
        $this->userID = $userID;
    }

    /**
     * @return int
     */
    public function getGalleryID() {
        return $this->galleryID;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getUserID() {
        return $this->userID;
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