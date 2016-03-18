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
    private $name;

    /**
     * Identifikator korisnika.
     * @var int
     */
    private $userID;

    private $errors;

    /**
     * Stvara novu galeriju
     *
     * @param $galleryID int
     * @param $description string
     * @param $name string
     * @param $userID string
     */
    public function __construct($description, $name, $userID, $galleryID = null) {
        $this->galleryID = $galleryID;
        $this->description = $description;
        $this->name = $name;
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
    public function getName() {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    public function validate() {
        if (!$this->name) {
            $this->errors["name"] = "Gallery name is required.";
        } else if (strlen($this->name) > 100) {
            $this->errors["name"] = "Gallery name can be up to 100 characters long.";
        }

        if ($this->description && strlen($this->description) > 500) {
            $this->errors["description"] = "Gallery description can be up to 500 characters long.";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

}