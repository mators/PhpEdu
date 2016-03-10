<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja html tag.
 */
class HTMLHtmlElement extends HTMLElement {

    /**
     * Stvara html element.
     * @param HTMLCollection|null $children
     */
    public function __construct(HTMLCollection $children = null) {
        parent::__construct("html", true, $children);
    }

}
