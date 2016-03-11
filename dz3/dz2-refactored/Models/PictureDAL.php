<?php


/**
 * Data Access Layer za slike.
 */
class PictureDAL extends DAL {

    private static $PHOTO_KEYS = ['id', 'title', 'description', 'userId', 'galleryId'];
    private static $FILE = "/data/slike.txt";
    private static $ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
    private static $SMALL = 64;
    private static $MEDIUM = 128;
    private static $LARGE = 512;

    public function getPictureById($pictureID) {
        $picture = $this->getByID($pictureID, self::$FILE, self::$PHOTO_KEYS);
        if (null != $picture) {
            return $this->newPictureFromData($picture);
        }
    }

    public function savePicture(Picture $picture) {
        file_put_contents(self::$FILE, $picture->__toString(), FILE_APPEND | LOCK_EX);
    }

    public function getUserPictures($userID) {
        return $this->getCollection($userID, "userId", self::$PHOTO_KEYS, self::$FILE);
    }

    private static function newPictureFromData($pictureData) {
        return new Gallery(
            $pictureData["id"],
            $pictureData["title"],
            $pictureData["description"],
            $pictureData["userId"],
            $pictureData["galleryId"]
        );
    }
}