<?php

namespace app\views;

use app\models\Gallery;
use app\oipa\view\AbstractView;
use app\router\Router as R;


class GalleriesView extends AbstractView {

    private $galleries = [];

    protected function outputHTML() {
        $username = R::getRoute("listGalleries")->getParam("username");
        ?>

        <div class="page container">

            <?php if (empty($this->galleries)) { ?>

                <div class="container center_div">
                    <div class="alert alert-info" role="alert">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        <?php if (isCurrentUser($username)) { ?>
                            You don't have a gallery. Try creating one.
                        <?php } else { ?>
                            User <strong><?php echo $username; ?></strong> doesn't have any galleries yet.
                        <?php } ?>
                    </div>
                </div>

            <?php } else { ?>
                <?php if (isCurrentUser($username)) { ?>
                    <a href="<?php echo R::getRoute("addGallery")->generate(["username" => $username]); ?>"
                       type="button" class="btn btn-primary btn-lg pull-right">
                        New gallery
                    </a>
                <?php } ?>
                <h3>Galleries</h3>

                <?php
                /* @var $gallery Gallery */
                foreach ($this->galleries as $gallery) { ?>

                <div class="list-group">
                    <a href="<?php echo R::getRoute("viewGallery")->generate(["username" => $username, "id" => $gallery->getGalleryID()]); ?>"
                       class="list-group-item">
                        <h4 class="list-group-item-heading"><?php echo __($gallery->getName()); ?></h4>
                        <p class="list-group-item-text"><?php echo __($gallery->getDescription()); ?></p>
                    </a>
                </div>

                <?php } ?>
            <?php } ?>
        </div>

        <?php
    }

    public function setGalleries($galleries) {
        $this->galleries = $galleries;
    }

}