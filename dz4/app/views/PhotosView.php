<?php

namespace app\views;

use app\models\Photo;
use app\oipa\view\AbstractView;
use app\router\Router as R;
use app\dispatcher\DefaultDispatcher as D;


class PhotosView extends AbstractView {

    private $photos = [];

    protected function outputHTML() {
        $username = D::getInstance()->getMatched()->getParam("username");
        ?>

        <div class="page container">

            <?php if (empty($this->photos)) { ?>

                <div class="container center_div">
                    <div class="alert alert-info" role="alert">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        <?php if (isCurrentUser($username)) { ?>
                            You don't have any photos. Try uploading one.
                        <?php } else { ?>
                            User <strong><?php echo $username; ?></strong> doesn't have any photos yet.
                        <?php } ?>
                    </div>
                </div>

            <?php } else { ?>
                <?php if (isCurrentUser($username)) { ?>
                    <a href="<?php echo R::getRoute("addPhoto")->generate(["username" => $username]); ?>"
                       type="button" class="btn btn-primary btn-lg pull-right">
                        New photo
                    </a>
                <?php } ?>
                <h3>Photos</h3>

                <div class="row">
                <?php
                /* @var $photo Photo */
                foreach ($this->photos as $photo) { ?>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="<?php echo R::getRoute("viewPhoto")->generate(["username" => $username, "id" => $photo->getPictureID()]) ?>">
                                <div class="image"><img src="data:image/png;base64,<?php echo $photo->getPhoto(); ?>" /></div>
                                <div class="caption">
                                    <h4 class="crop"><?php echo $photo->getName(); ?></h4>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php } ?>
                </div>
            <?php } ?>
        </div>

        <?php
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }

}