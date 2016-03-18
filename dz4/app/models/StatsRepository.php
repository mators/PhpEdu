<?php

namespace app\models;

use app\db\DBPool;
use app\oipa\model\Repository;


class StatsRepository extends Repository {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new StatsRepository();
        }
        return self::$instance;
    }

    public function get($photoId) {
        return parent::getSingleOrNull(["photo_id" => $photoId]);
    }

    public function addView($photoId) {
        $sql = "INSERT INTO `views` (`photo_id`, `date`, `count`) VALUES (" . $photoId .
            ",'" . date("Y-m-d") ."',1) ON DUPLICATE KEY UPDATE `count`=`count`+1";
        DBPool::getInstance()->prepare($sql)->execute();
    }

    public function getViews($photoId) {
        $sql = "SELECT SUM(`count`) AS result FROM `views` WHERE `photo_id`=".$photoId;
        $statement = DBPool::getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetch()->result;
    }

    protected function getTable() {
        return "image_views_pivot";
    }

    protected function modelFromData($data)  {
        return $data;
    }

}