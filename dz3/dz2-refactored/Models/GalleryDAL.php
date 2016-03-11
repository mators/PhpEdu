<?php


/**
 * Data Access Layer za galeriju.
 */
class GalleryDAL extends DAL {

    private static $GALLERY_KEYS = ['id', 'description', 'title', 'userId'];
    private static $FILE = "data/galerije.txt";

    public function getGalleryById($galleryID) {
        $gallery = $this->getByID($galleryID, self::$FILE, self::$GALLERY_KEYS);
        if (null != $gallery) {
            return $this->newGalleryFromData($gallery);
        }
    }

    public function saveGallery(Gallery $gallery) {
        file_put_contents(self::$FILE, $gallery->__toString(), FILE_APPEND | LOCK_EX);
    }

    public function getUserGalleries($userID) {
        return $this->getCollection($userID, "userId", self::$GALLERY_KEYS, self::$FILE);
    }

    private static function newGalleryFromData($galleryData) {
        return new Gallery(
            $galleryData["id"],
            $galleryData["firstname"],
            $galleryData["lastname"],
            $galleryData["email"],
            $galleryData["password"]
        );
    }

}