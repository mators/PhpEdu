<?php

use app\router\Router as R;


R::registerRoutes([

    // R::route("/url/path/(?P<param>\\d+)", "controller", "action", "name"),

    R::route("/", "home", "index", "index"),
    R::route("/error", "home", "error", "error"),

    R::route("/login", "auth", "login", "login"),
    R::route("/logout", "auth", "logout", "logout"),
    R::route("/register", "auth", "register", "register"),

    R::route("/users/(?P<username>\\w+)", "user", "index", "viewUser"),
    R::route("/users/(?P<username>\\w+)/edit", "user", "edit", "editUser"),
    R::route("/users/(?P<username>\\w+)/delete", "user", "delete", "deleteUser"),

    R::route("/users/(?P<username>\\w+)/galleries/add", "gallery", "add", "addGallery"),
    R::route("/users/(?P<username>\\w+)/galleries/(?P<id>\\d+)/edit", "gallery", "edit", "editGallery"),
    R::route("/users/(?P<username>\\w+)/galleries/(?P<id>\\d+)/delete", "gallery", "delete", "deleteGallery"),
    R::route("/users/(?P<username>\\w+)/galleries/(?P<id>\\d+)", "gallery", "index", "viewGallery"),
    R::route("/users/(?P<username>\\w+)/galleries", "gallery", "listGalleries", "listGalleries"),

    R::route("/users/(?P<username>\\w+)/photos/add", "photo", "add", "addPhoto"),
    R::route("/users/(?P<username>\\w+)/photos/(?P<id>\\d+)/edit", "photo", "edit", "editPhoto"),
    R::route("/users/(?P<username>\\w+)/photos/(?P<id>\\d+)/delete", "photo", "delete", "deletePhoto"),
    R::route("/users/(?P<username>\\w+)/photos/(?P<id>\\d+)", "photo", "index", "viewPhoto"),
    R::route("/users/(?P<username>\\w+)/photos", "photo", "listPhotos", "listPhotos"),

    R::route("/getStats/(?P<id>\\d+)", "photo", "getStats", "getStats")
]);
