<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja body element.
 */
class HTMLBodyElement extends HTMLElement {

    /**
     * Stvara body element.
     * @param $children HTMLCollection|null
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("body", true, $children);
    }

}
