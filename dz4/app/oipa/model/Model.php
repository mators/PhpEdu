<?php

namespace app\oipa\model;


interface Model extends \Serializable {

    public function equals(Model $model);

}