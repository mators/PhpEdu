<?php

namespace app\oipa\model;


interface Model {

    public function validate();

    public function getErrors();

}