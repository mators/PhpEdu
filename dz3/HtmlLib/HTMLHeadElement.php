<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja head element.
 */
class HTMLHeadElement extends HTMLElement {

    /**
     * Stvara head element.
     * @param $children HTMLCollection|null
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("head", true, $children);
    }

}
