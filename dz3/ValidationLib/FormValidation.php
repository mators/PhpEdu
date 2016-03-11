<?php

namespace hr\sofascore\dz3\validationlib;

/**
 * Klasa za validaciju podataka ispunjenih u html formi.
 */
class FormValidation {

    private static $EMAIL = "email";
    private static $LENGTH = "length";
    private static $REQUIRED = "required";
    private static $URL = "url";

    /**
     * Asocijativno polje u kojem su spremljena sva pravila za sva
     * polja koja je potrebno provjeriti.
     * @var array
     */
    private $rules;

    /**
     * Asocijativno polje u koje se spremaju greske.
     * @var array
     */
    private $errors;

    /**
     * Postavlja nova pravila za validaciju podataka.
     * @param $rules array  				pravila za validaciju podataka
     */
    public function set_rules($rules) {
        if (!is_array($rules)) {
            throw new \InvalidArgumentException("rules - array expected");
        }
        $this->rules = $rules;
    }

    /**
     * Pokrece validaciju podataka.
     *
     * @param $data array                   podaci iz $_POST
     * @return boolean					    true ako svi podaci zadovoljavaju pravila
     */
    public function validate($data) {
        $this->errors = [];

        foreach ($this->rules as $name => $rule) {

            if (!array_key_exists($name, $data)) {
                $this->errors[$name] = "No form element with given name: " . $name . ".";
                return false;
            }

            foreach (explode("|", $rule) as $item) {
                if ($item == self::$EMAIL && !$this->validate_email($data[$name])) {
                    $this->errors[$name] = "Email address is not valid.";
                }
                if (strpos($item, self::$LENGTH) === 0) {
                    $length = (int)preg_split("/\\[|\\]/", $item)[1];
                    if (!$this->validate_length($data[$name], $length)) {
                        $this->errors[$name] = "Required length: " . $length . ".";
                    }
                }
                if ($item == self::$REQUIRED && !$this->validate_required($data[$name])) {
                    $this->errors[$name] = "Required field.";
                }
                if ($item == self::$URL && !$this->validate_url($data[$name])) {
                    $this->errors[$name] = "URL is not valid.";
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Provjerava je li dobivena vrijednost ispravna email adresa.
     *
     * @param $data mixed					podatak koji je potrebno validirati
     * @return boolean  					true ako je podatak zbilja email adresa
     */
    public function validate_email($data) {
        return preg_match(
            "/^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$/",
            strtolower($data)
        ) == 1;
    }

    /**
     * Provjerava je li predana vrijednost odgovarajuceg broja znakova.
     *
     * @param $data mixed 					podatak koji je potrebno validirati
     * @param $length integer				zeljeni broj znakova
     * @return boolean					    true ako je podatak odgovarajuceg broja znakova
     */
    public function validate_length($data, $length) {
        return strlen($data) == $length;
    }

    /**
     * Provjerava je li polje uopce popunjeno.
     *
     * @param $data mixed					podatak koji je potrebno validirati
     * @return boolean 					    true ako je polje popunjeno
     */
    public function validate_required($data) {
        return !empty($data);
    }

    /**
     * Provjerava je li dobivena vrijednost ispravan url.
     *
     * @param $data mixed						podatak koji je potrebno validirati
     * @return boolean      					true ako je podatak zbilja ispravno napisan url
     */
    public function validate_url($data) {
        return preg_match(
            "/\\b(?:(?:https?|ftp):\\/\\/|www\\.)[-a-z0-9+&@#\\/%?=~_|!:,.;]*[-a-z0-9+&@#\\/%=~_|]/i",
            $data
        ) == 1;
    }

    /**
     * Ispisuje pogreske koje su se dogodile prilikom validacije.
     */
    public function display_validation_errors() {
        $str = "Fields with errors: ";
        foreach ($this->errors as $field) {
            $str .= $field . ", ";
        }
        echo substr($str, 0, -2) . ".";
    }

    /**
     * Vraca pogreske koje su se dogodile prilikom validacije.
     * @return array						polje pogresaka prilikom validacije
     */
    public function validation_errors() {
        return $this->errors;
    }
}
