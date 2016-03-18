<?php

namespace app\views;

use app\models\Gallery;
use app\oipa\view\AbstractView;


class GalleryFormView extends AbstractView {

    private $errors = [];

    /**
     * @var Gallery
     */
    private $gallery;

    private $title;

    private $action;

    protected function outputHTML() {
        ?>
        <div class="page container center_div">
            <h3><?php echo $this->title; ?></h3>

            <form class="form-horizontal" method="post" action="<?php echo $this->action; ?>">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Gallery name"
                               value="<?php echo $this->gallery->getName(); ?>"
                        />
                        <span class="text-danger"><?php echo element("name", $this->errors, ""); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" id="description" name="description"><?php echo $this->gallery->getDescription(); ?></textarea>
                        <span class="text-danger"><?php echo element("description", $this->errors, ""); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default"><?php echo $this->title; ?></button>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    public function setErrors($errors) {
        $this->errors = $errors;
    }

    public function setGallery($gallery) {
        $this->gallery = $gallery;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAction($action) {
        $this->action = $action;
    }

}