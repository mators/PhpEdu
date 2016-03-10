<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Implementacija cvor koji predstavlja
 */
class HTMLTextNode extends HTMLNode {

    /**
     * Sadrzaj tekstualnog cvora
     * @var string
     */
    private $text;

    /**
     * Stvara novo tekstualni cvor zadanog sadrzaja
     * @param $text string					    tekst cvora
     */
    public function __construct($text) {
        if (!is_string($text)) {
            throw new \InvalidArgumentException("text - string expected");
        }
        $this->text = $text;
    }

    /**
     * Alias metode __toString u situacijama kada bi ova
     * metoda bila semanticki ispravnija
     */
    public function get_text() {
        return $this->text;
    }

    /**
     * Vraca sadrzaj cvora.
     */
    public function __toString() {
        return $this->text;
    }
}
