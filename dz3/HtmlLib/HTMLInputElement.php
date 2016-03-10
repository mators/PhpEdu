<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja input element.
 */
class HTMLInputElement extends HTMLElement {

    /**
     * Stvara input element.
     */
    public function __construct() {
        parent::__construct("input", false);
    }

}