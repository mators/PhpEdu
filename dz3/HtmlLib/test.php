<?php

require_once('../autoloader.php');

use hr\sofascore\dz3\htmllib\HTMLHtmlElement;
use hr\sofascore\dz3\htmllib\HTMLCollection;
use hr\sofascore\dz3\htmllib\HTMLBodyElement;
use hr\sofascore\dz3\htmllib\HTMLElement;
use hr\sofascore\dz3\htmllib\HTMLTextNode;
use hr\sofascore\dz3\htmllib\HTMLTableElement;
use hr\sofascore\dz3\htmllib\HTMLRowElement;
use hr\sofascore\dz3\htmllib\HTMLCellElement;


echo new HTMLHtmlElement(new HTMLCollection([
    new HTMLHtmlElement(),
    new HTMLBodyElement(new HTMLCollection([

        new HTMLElement("h1", true, new HTMLCollection([
            new HTMLTextNode("Naslov")
        ])),

        new HTMLTableElement([
            new HTMLRowElement([
                new HTMLCellElement([new HTMLTextNode("Prvi redak")]),
                new HTMLCellElement([new HTMLTextNode("Prvi redak")])
            ]),
            new HTMLRowElement([
                new HTMLCellElement([new HTMLTextNode("Drugi redak")])
            ])
        ])
    ]))
]));
