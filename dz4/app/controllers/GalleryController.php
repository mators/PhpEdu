<?php

namespace app\controllers;

use app\models\Gallery;
use app\models\GalleryRepository;
use app\models\PhotoRepository;
use app\models\UserRepository;
use app\oipa\controller\Controller;
use app\views\GalleryFormView;
use app\views\CommonView;
use app\views\GalleriesView;
use app\views\GalleryView;
use app\router\Router as R;
use app\dispatcher\DefaultDispatcher as D;


class GalleryController implements Controller {

    public function index() {
        $galleryId = D::getInstance()->getMatched()->getParam("id");
        $gallery = GalleryRepository::getInstance()->get($galleryId);

        if (null === $gallery) {
            redirect(R::getRoute("error")->generate());
        }

        $username = D::getInstance()->getMatched()->getParam("username");
        $photos = PhotoRepository::getInstance()->getByGalleryId($galleryId);

        if (null === $photos) {
            $photos = [];
        }

        echo new CommonView([
            "title" => "OIPA Phlickr - " . $username,
            "body" => new GalleryView([
                "gallery" => $gallery,
                "photos" => array_reverse($photos)
            ])
        ]);
    }

    public function add() {
        $username = D::getInstance()->getMatched()->getParam("username");
        if (!isCurrentUser($username)) {
            redirect(R::getRoute("error")->generate());
        }

        if (isPost()) {

            $gallery = new Gallery(
                post("description"),
                post("name"),
                user()["id"]
            );

            if ($gallery->validate()) {
                GalleryRepository::getInstance()->save($gallery);
                redirect(R::getRoute("listGalleries")->generate(user()));
            }

            echo new CommonView([
                "title" => "OIPA Phlickr - New gallery",
                "body" => new GalleryFormView([
                    "title" => "Create gallery",
                    "gallery" => $gallery,
                    "errors" => $gallery->getErrors(),
                    "action" => R::getRoute("addGallery")->generate(user())
                ])
            ]);

        } else {
            echo new CommonView([
                "title" => "OIPA Phlickr - New gallery",
                "body" => new GalleryFormView([
                    "title" => "Create gallery",
                    "gallery" => new Gallery("", "", ""),
                    "action" => R::getRoute("addGallery")->generate(user())
                ])
            ]);
        }
    }

    public function edit() {
        $username = D::getInstance()->getMatched()->getParam("username");
        if (!isCurrentUser($username)) {
            redirect(R::getRoute("error")->generate());
        }

        $galleryId = D::getInstance()->getMatched()->getParam("id");
        $gallery = GalleryRepository::getInstance()->get($galleryId);

        if (null === $gallery) {
            redirect(R::getRoute("error")->generate());
        }

        if (isPost()) {
            $gallery->setName(post("name"));
            $gallery->setDescription(post("description"));

            if ($gallery->validate()) {
                GalleryRepository::getInstance()->update($gallery);
                redirect(R::getRoute("viewGallery")->generate([
                    "username" => $username,
                    "id" => $galleryId
                ]));
            }

            echo new CommonView([
                "title" => "OIPA Phlickr - Edit gallery",
                "body" => new GalleryFormView([
                    "title" => "Edit gallery",
                    "errors" => $gallery->getErrors(),
                    "gallery" => $gallery,
                    "action" => R::getRoute("editGallery")->generate([
                        "username" =>  $username,
                        "id" => $galleryId
                    ])
                ])
            ]);

        } else {
            echo new CommonView([
                "title" => "OIPA Phlickr - Edit gallery",
                "body" => new GalleryFormView([
                    "title" => "Edit gallery",
                    "gallery" => $gallery,
                    "action" => R::getRoute("editGallery")->generate([
                        "username" =>  $username,
                        "id" => $galleryId
                    ])
                ])
            ]);
        }
    }

    public function delete() {

    }

    public function listGalleries() {

        $username = D::getInstance()->getMatched()->getParam("username");
        $user = UserRepository::getInstance()->getByUsername($username);

        if (null === $user) {
            redirect(R::getRoute("error")->generate());
        }

        $galleries = GalleryRepository::getInstance()->getByUser($user->getUserID());

        if (null === $galleries) {
            $galleries = [];
        }

        echo new CommonView([
            "title" => "OIPA Phlickr - " . $username,
            "body" => new GalleriesView(["galleries" => array_reverse($galleries)])
        ]);
    }

}