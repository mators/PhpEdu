<?php

namespace app\controllers;

use app\lib\graficonlib\BarChart;
use app\lib\graficonlib\DataCollection;
use app\lib\graficonlib\DataCollectionItem;
use app\lib\graficonlib\Legend;
use app\lib\graficonlib\LegendItem;

use app\models\Photo;
use app\models\GalleryRepository;
use app\models\UserRepository;
use app\models\PhotoRepository;
use app\models\TagRepository;
use app\models\StatsRepository;
use app\oipa\controller\Controller;
use app\views\CommonView;
use app\views\PhotoFormView;
use app\views\PhotosView;
use app\views\PhotoView;
use app\router\Router as R;
use app\dispatcher\DefaultDispatcher as D;


class PhotoController implements Controller {

    private static $FILE_KEYS = ['name', 'type', 'size', 'tmp_name', 'error'];
    private static $ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

    public function index() {
        $photoId = D::getInstance()->getMatched()->getParam("id");
        $photo = PhotoRepository::getInstance()->get($photoId);

        if (null === $photo) {
            redirect(R::getRoute("error")->generate());
        }

        $username = D::getInstance()->getMatched()->getParam("username");
        $tags = TagRepository::getInstance()->getByPhoto($photoId);

        if (null === $tags) {
            $tags = [];
        }

        StatsRepository::getInstance()->addView($photoId);
        $stats = StatsRepository::getInstance()->get($photoId);
        $views = StatsRepository::getInstance()->getViews($photoId);

        echo new CommonView([
            "title" => "OIPA Phlickr - " . $username,
            "body" => new PhotoView([
                "photo" => $photo,
                "tags" => $tags,
                "views" => $views
            ])
        ]);
    }

    public function add() {
        $username = R::getRoute("addPhoto")->getParam("username");
        if (!isCurrentUser($username)) {
            redirect(R::getRoute("error")->generate());
        }
        $galleries = GalleryRepository::getInstance()->getByUser(user()["id"]);

        if (isPost()) {

            $file = elements(self::$FILE_KEYS, $_FILES["file"]);
            $errors = [];
            $name = post("name");
            $imageString = "";

            if ($file["error"] > 0) {
                $errors["file"] = "You have to select a photo.";
            } else {

                $name = empty($name) ? $file["name"] : $name;

                if (!in_array(strtolower($file["type"]), self::$ALLOWED_FILE_TYPES)) {
                    $errors["file"] = "File format not supported.";
                } else {

                    if ($file["size"] > 512000) {
                        $errors["file"] = "Photo can be up to 500kB.";
                    }

                    list($width, $height) = getimagesize($file['tmp_name']);

                    if ($width < 128 || $height < 128) {
                        $errors["file"] = "Photo must be at least 128x128.";
                    }
                }
            }

            if (empty($errors)) {
                $imageString = stringFromImageInfo($file);
            }

            $photo = new Photo(
                $name,
                post("description"),
                user()["id"],
                post("galleryId"),
                $imageString
            );

            if($photo->validate() && empty($errors)) {
                PhotoRepository::getInstance()->save($photo);
                redirect(R::getRoute("listPhotos")->generate(user()));
            }

            echo new CommonView([
                "title" => "OIPA Phlickr - Add photo",
                "body" => new PhotoFormView([
                    "title" => "Add photo",
                    "errors" => array_merge($photo->getErrors(), $errors),
                    "galleries" => $galleries,
                    "action" => R::getRoute("addPhoto")->generate(user()),
                    "photo" => $photo
                ])
            ]);

        } else {
            echo new CommonView([
                "title" => "OIPA Phlickr - AddPhoto" . $username,
                "body" => new PhotoFormView([
                    "title" => "Add photo",
                    "galleries" => $galleries,
                    "action" => R::getRoute("addPhoto")->generate(user()),
                    "photo" => new Photo("", "", "", "", "")
                ])
            ]);
        }

    }

    public function edit() {

    }

    public function delete() {

    }

    public function listPhotos() {
        $username = D::getInstance()->getMatched()->getParam("username");
        $user = UserRepository::getInstance()->getByUsername($username);

        if (null === $user) {
            redirect(R::getRoute("error")->generate());
        }

        $photos = PhotoRepository::getInstance()->getByUser($user->getUserID());

        if (null === $photos) {
            $photos = [];
        }

        echo new CommonView([
            "title" => "OIPA Phlickr - " . $username,
            "body" => new PhotosView(["photos" => array_reverse($photos)])
        ]);
    }

    public function getStats() {

        header('Content-Type: image/png');

        $photoId = D::getInstance()->getMatched()->getParam("id");

        $stats = StatsRepository::getInstance()->get($photoId);

        $barChart = new BarChart("Views last week", 300, 700);
        $barChart->set_font_size(5);

        $data = new DataCollection();
        $data->add_items([
            new DataCollectionItem((int)$stats->day1, date("Y-m-d", strtotime("-6 days"))),
            new DataCollectionItem((int)$stats->day2, date("Y-m-d", strtotime("-5 days"))),
            new DataCollectionItem((int)$stats->day3, date("Y-m-d", strtotime("-4 days"))),
            new DataCollectionItem((int)$stats->day4, date("Y-m-d", strtotime("-3 days"))),
            new DataCollectionItem((int)$stats->day5, date("Y-m-d", strtotime("-2 days"))),
            new DataCollectionItem((int)$stats->day6, date("Y-m-d", strtotime("-1 days"))),
            new DataCollectionItem((int)$stats->day7, date("Y-m-d"))
        ]);
        $ids = $barChart->add_data($data);
        $barChart->color_data(66, 139, 202, $ids);

        $legend = new Legend([
            new LegendItem("views", 66, 139, 202)
        ]);
        $legend->set_font_size(4);
        $barChart->set_legend($legend, 0, 0);

        imagepng($barChart->render());
    }

}