<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja celiju tablice (td element).
 */
class HTMLCellElement extends HTMLElement {

    /**
     * Stvara td element.
     */
    public function __construct($elements) {
        parent::__construct("td");
        $this->children = new HTMLCollection($elements);
    }

}
