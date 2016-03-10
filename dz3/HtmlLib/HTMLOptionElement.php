<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja option element.
 */
class HTMLOptionElement extends HTMLElement {

    /**
     * Stvara option element.
     * @param $children HTMLCollection|null
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("option", true, $children);
    }

}
