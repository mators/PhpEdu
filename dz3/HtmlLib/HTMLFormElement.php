<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja form element.
 */
class HTMLFormElement extends HTMLElement {

    /**
     * Stvara form element.
     * @param $children HTMLCollection|null
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("form", true, $children);
    }

}
