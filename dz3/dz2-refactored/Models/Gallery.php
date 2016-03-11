<?php


/**
 * Predstavlja galeriju slika u aplikaciji.
 */
class Gallery {

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

    /**
     * @return string
     */
    function __toString() {
        return $this->galleryID . ";"
            . $this->description . ";"
            . $this->title . ";"
            . $this->userID . "\n";
    }

}