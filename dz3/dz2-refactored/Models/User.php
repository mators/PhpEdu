<?php


/**
 * Predstavlja korisnika aplikacije.
 */
class User {

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
     * Hashirana sifra korisnika.
     * @var string
     */
    private $password;

    /**
     * Stvara novog korisnika.
     *
     * @param $firstName string
     * @param $lastName string
     * @param $eMail string
     * @param $password string
     */
    public function __construct($userID, $firstName, $lastName, $eMail, $password) {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->eMail = $eMail;
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
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->userID . ";"
            . $this->firstName . ";"
            . $this->lastName . ";"
            . $this->eMail . ";"
            . $this->password . "\n";
    }

}