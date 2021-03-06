<?php

namespace app\models;

use app\oipa\model\Repository;


class UserRepository extends Repository {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    /**
     * @param $id
     * @return User|null
     */
    public function get($id) {
        return parent::get($id);
    }

    /**
     * @param $username
     * @return User|null
     */
    public function getByUsername($username) {
        return parent::getSingleOrNull([ "username" => $username]);
    }

    /**
     * @param $username
     * @param $password
     * @return User|null
     */
    public function getByUsernameAndPassword($username, $password) {
        return parent::getSingleOrNull([ "username" => $username, "password" => sha1($password) ]);
    }

    public function save(User $user) {
        return parent::save([
            "firstname" => $user->getFirstName(),
            "lastname" => $user->getLastName(),
            "email" => $user->getEMail(),
            "username" => $user->getUsername(),
            "password" => $user->getPassword()
        ]);
    }

    public function update(User $user) {
        parent::update($user->getUserID(), [
            "firstname" => $user->getFirstName(),
            "lastname" => $user->getLastName(),
            "email" => $user->getEMail(),
            "username" => $user->getUsername(),
            "password" => $user->getPassword()
        ]);
    }

    public function delete($id) {
        parent::delete($id);
    }

    protected function getTable() {
        return "users";
    }

    protected function modelFromData($data) {
        return new User(
            $data->firstname,
            $data->lastname,
            $data->email,
            $data->username,
            $data->password,
            $data->id
        );
    }

}