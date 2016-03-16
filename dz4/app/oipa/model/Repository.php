<?php

namespace app\oipa\model;


interface Repository {

    public function get($id);

    public function getAll(array $conditions = []);

    public function save(Model $model);

    public function update($id, Model $model);

    public function delete($id);

}