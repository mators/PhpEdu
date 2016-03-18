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
    private $name;

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
     * @var string
     */
    private $photo;

    private $errors;

    /**
     * Stvara sliku.
     * @param $pictureID int
     * @param $name string
     * @param $description string
     * @param $userID int
     * @param $galleryID int
     * @param $photo string
     */
    public function __construct($name, $description, $userID, $galleryID, $photo, $pictureID = null) {
        $this->pictureID = $pictureID;
        $this->name = $name;
        $this->description = $description;
        $this->userID = $userID;
        $this->galleryID = $galleryID;
        $this->photo = $photo;
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
    public function getName() {
        return $this->name;
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

    /**
     * @return string
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * @param resource $photo
     */
    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @param int $userID
     */
    public function setUserID($userID) {
        $this->userID = $userID;
    }

    /**
     * @param int $galleryID
     */
    public function setGalleryID($galleryID) {
        $this->galleryID = $galleryID;
    }

    public function validate() {
        $this->errors = [];
        if (!empty($this->name) && strlen($this->name) > 100) {
            $this->errors["name"] = "Photo name can be up to 100 characters long.";
        }

        if ($this->description && strlen($this->description) > 500) {
            $this->errors["description"] = "Photo description can be up to 500 characters long.";
        }

        if (empty($this->galleryID)) {
            $this->errors["gallery"] = "Gallery is required.";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

}