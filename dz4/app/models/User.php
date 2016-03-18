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

    private $errors = [];

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
    public function __construct($firstName, $lastName, $eMail, $username, $password, $userID = null) {
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
        return sha1($this->password);
    }

    public function validate() {
        if (!empty($this->firstName) && strlen($this->firstName) > 40) {
            $this->errors["firstname"] = "First name can be up to 40 characters long.";
        }

        if (!empty($this->lastName) && strlen($this->lastName) > 40) {
            $this->errors["lastname"] = "Last name can be up to 40 characters long.";
        }

        if (empty($this->username)) {
            $this->errors["username"] = "Username is required.";
        } else if (strlen($this->username) > 40) {
            $this->errors["username"] = "Username can be up to 40 characters long.";
        }

        if (empty($this->eMail)) {
            $this->errors["email"] = "E-mail is required.";
        } else if (preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$/i", $this->eMail) != 1) {
            $this->errors["email"] = "Invalid E-mail format.";
        }

        if (empty($this->password)) {
            $this->errors["password"] = "Password is required.";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

}