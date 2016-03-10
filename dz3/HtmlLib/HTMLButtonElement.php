<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja button element.
 */
class HTMLButtonElement extends HTMLElement {

    /**
     * Stvara button element.
     * @param $children HTMLCollection|null
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("button", true, $children);
    }

}
