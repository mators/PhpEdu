<?php


/**
 * Data Access Layer za korisnika.
 */
class UserDAL extends DAL {

    private static $USER_KEYS = ['id', 'firstname', 'lastname', 'email', 'password'];
    private static $FILE = "data/korisnici.txt";

    /**
     * Vraca korisnika sa definiranim emailom i lozinkom ili NULL ako takav korisnik ne postoji.
     *
     * @param $email string                         Mail korisnika
     * @param $password string                      Hashirana sifra korisnika
     * @return User|null dohvaceni korisnik iz korisnici.txt ili null.
     */
    public function getUserByInfo($email, $password) {
        $lines = file_get_contents(self::$FILE);
        foreach (explode("\n", $lines) as $line) {
            if (!empty($line)) {
                $user = $this->deserialize($line, self::$USER_KEYS);
                if ($user["email"] === $email &&
                    $user["password"] === $password) {

                    return $this->newUserFromData($user);
                }
            }
        }
        return NULL;
    }

    public function getUserById($userID) {
        $user = $this->getByID($userID, self::$FILE, self::$USER_KEYS);
        if (null != $user) {
            return $this->newUserFromData($user);
        }
    }

    public function saveUser(User $user) {
        file_put_contents(self::$FILE, $user->__toString(), FILE_APPEND | LOCK_EX);
    }

    private static function newUserFromData($userData) {
        return new User(
            $userData["id"],
            $userData["firstname"],
            $userData["lastname"],
            $userData["email"],
            $userData["password"]
        );
    }
}