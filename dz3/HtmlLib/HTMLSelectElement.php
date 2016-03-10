<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja select element.
 */
class HTMLSelectElement extends HTMLElement {

    /**
     * Stvara select element.
     * @param $children HTMLCollection|null
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("select", true, $children);
    }

}
