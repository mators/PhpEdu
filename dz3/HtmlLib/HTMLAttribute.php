<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Implementacija HTML atributa
 */
class HTMLAttribute {

    /**
     * Naziv atributa
     * @var string
     */
    private $name;

    /**
     * Polje vrijednosti atributa.
     * @var array
     */
    private $value;

    /**
     * Kreira novi atribut prema zadanom imenu i vrijednosti(ma)
     *
     * @param string $name					    naziv atributa
     * @param mixed $value					    vrijednost (string) ili vrijednosti (array) atributa
     */
    public function __construct($name, $value) {
        if (!is_string($name)) {
            throw new \InvalidArgumentException("name - string expected");
        }
        if (is_string($value)) {
            $this->value = [$value];
        } else if (is_array($value)) {
            $this->value = $value;
        } else {
            throw new \InvalidArgumentException("value - string or array expected");
        }
        $this->name = $name;
    }

    /**
     * Atributu dodaje jednu novu vrijednost. Nije dozvoljeno
     * duplicirati vrijednosti.
     *
     * @param string $value                     vrijednost atributa
     */
    public function add_value($value) {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("value - string expected");
        }
        if (!in_array($value, $this->value)) {
            array_push($this->value, $value);
        }
    }

    /**
     * Atributu dodaje vise novih vrijednosti. Potrebno je paziti
     * da ne dodje do dupliciranja vrijednosti.
     *
     * @param array $values                     vrijednosti atributa
     */
    public function add_values($values) {
        if (!is_array($values)) {
            throw new \InvalidArgumentException("values - array expected");
        }
        array_unique(array_merge($this->value, $values));
    }

    /**
     * Uklanja postojecu vrijednost atributa.
     *
     * @param string $value					    vrijednost koju je potrebno ukloniti
     */
    public function remove_value($value) {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("value - string expected");
        }
        if(($key = array_search($value, $this->value)) !== false) {
            unset($this->value[$key]);
        }
    }

    /**
     * Vraca naziv atributa
     *
     * @return string							naziv atributa
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Zapisa atributa i njegove (njegovih) vrijednosti pomocu
     * niza znakova.
     */
    public function __toString() {
        return $this->name . '="' . implode(" ", $this->value) . '"';
    }
}
