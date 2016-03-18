<?php

namespace app\views;

use app\models\Photo;
use app\models\Gallery;
use app\oipa\view\AbstractView;


class PhotoFormView extends AbstractView {

    private $errors = [];

    /**
     * @var Photo
     */
    private $photo;

    private $title;

    private $action;

    private $galleries = [];

    protected function outputHTML() {
        ?>
        <div class="page container center_div">
            <h3><?php echo $this->title; ?></h3>

            <form class="form-horizontal" method="post" action="<?php echo $this->action; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Photo name"
                               value="<?php echo $this->photo->getName(); ?>"
                        />
                        <span class="text-danger"><?php echo element("name", $this->errors, ""); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" id="description" name="description"><?php echo $this->photo->getDescription(); ?></textarea>
                        <span class="text-danger"><?php echo element("description", $this->errors, ""); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gallery" class="col-sm-2 control-label">Gallery</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="gallery" name="galleryId">
                            <?php /* @var $gallery Gallery */
                            foreach ($this->galleries as $gallery) { ?>
                                <option value="<?php echo $gallery->getGalleryID(); ?>">
                                    <?php echo $gallery->getName(); ?>
                                </option>";
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?php echo element("gallery", $this->errors, ""); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="file" class="col-sm-2 control-label">Photo</label>
                    <div class="col-sm-10">
                        <input type="file" id="file" name="file">
                        <span class="text-danger"><?php echo element("file", $this->errors, ""); ?></span>
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

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function setGalleries($galleries) {
        $this->galleries = $galleries;
    }

}