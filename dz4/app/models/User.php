<?php

namespace app\models;

use app\oipa\model\Model;


/**
 * Predstavlja korisnika aplikacije.
 */
class User implements Model {

    /**
     * Id korisnika.
     * @var int
     */
    private $userID;

    /**
     * Ime korisnika.
     * @var string
     */
    private $firstName;

    /**
     * Prezime korisnika.
     * @var string
     */
    private $lastName;

    /**
     * Email korisnika.
     * @var string
     */
    private $eMail;

    /**
     * Korisnicko ime.
     * @var string
     */
    private $username;

    /**
     * Hashirana sifra korisnika.
     * @var string
     */
    private $password;

    /**
     * Stvara novog korisnika.
     *
     * @param $userID int
     * @param $firstName string
     * @param $lastName string
     * @param $eMail string
     * @param $username string
     * @param $password string
     */
    public function __construct($userID, $firstName, $lastName, $eMail, $username, $password) {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->eMail = $eMail;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getUserID() {
        return $this->userID;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEMail() {
        return $this->eMail;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    public function equals(Model $model) {
        // TODO: Implement equals() method.
    }

    public function serialize() {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized) {
        // TODO: Implement unserialize() method.
    }

}