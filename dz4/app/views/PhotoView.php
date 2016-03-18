<?php

namespace app\views;

use app\models\Photo;
use app\oipa\view\AbstractView;
use app\router\Router as R;
use app\dispatcher\DefaultDispatcher as D;


class PhotoView extends AbstractView {

    /**
     * @var Photo
     */
    private $photo;

    private $tags = [];

    private $views = 0;

    protected function outputHTML() {
        $username = D::getInstance()->getMatched()->getParam("username");
        ?>
        <div class="page container">

            <img class="img-responsive center-block" src="data:image/png;base64,<?php echo $this->photo->getPhoto(); ?>" />
            <span class="badge"><?php echo $this->views; ?></span> views

            <div>
                <p>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Photo details
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p><strong>Name: </strong><?php echo $this->photo->getName(); ?></p>
                                    <p><strong>Description: </strong><br><?php echo $this->photo->getDescription(); ?></p>
                                    <p><strong>Tags: </strong><?php echo implode(", ", $this->tags); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Views chart
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <img class="img-responsive center-block" src="<?php echo R::getRoute("getStats")->generate(["id" => $this->photo->getPictureID()]); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </p>
            </div>

        </div>
        <?php
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

    public function setViews($views) {
        $this->views = $views;
    }

}