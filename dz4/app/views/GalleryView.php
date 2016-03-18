<?php

namespace app\views;

use app\models\Gallery;
use app\models\Photo;
use app\oipa\view\AbstractView;
use app\router\Router as R;


class GalleryView extends AbstractView {

    /**
     * @var Gallery
     */
    private $gallery;

    private $photos;

    protected function outputHTML() {
        $username = R::getRoute("viewGallery")->getParam("username");
        ?>
        <div class="page container">
            <div class="center_div">
                <?php if (isCurrentUser($username)) { ?>
                    <a href="<?php echo R::getRoute("editGallery")->generate([
                        "username" => $username,
                        "id" => $this->gallery->getGalleryID()]); ?>"
                       type="button" class="btn btn-primary btn-lg pull-right">
                        Edit gallery
                    </a>
                <?php } ?>
                <h3>Gallery info</h3>

                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Gallery name: </strong><?php echo __($this->gallery->getName()); ?><br>
                    </li>
                    <li class="list-group-item">
                        <strong>Gallery description: </strong><br><?php echo __($this->gallery->getDescription()); ?><br>
                    </li>
                    <li class="list-group-item">
                        <strong>Number of photos: </strong><?php echo count($this->photos); ?><br>
                    </li>
                </ul>
            </div>

            <?php if (!empty($this->photos)) { ?>
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
                                    <h4 class="crop"><?php echo __($photo->getName()); ?></h4>
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

    public function setGallery($gallery) {
        $this->gallery = $gallery;
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }

}