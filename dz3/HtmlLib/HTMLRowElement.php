<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja row element (tr).
 */
class HTMLRowElement extends HTMLElement {

    /**
     * Stvara redak tablice s danim celijama.
     * @param array $cells                      celije za redak.
     */
    public function __construct($cells = [])
    {
        parent::__construct("tr");
        if (!is_array($cells)) {
            throw new \InvalidArgumentException("cells - array expected");
        }
        $this->children = new HTMLCollection($cells);
    }

    /**
     * Dodaje retku novu celiju. Ako je predani parametar jednak 'null',
     * tada se dodaje prazna celija.
     *
     * @param $cell HTMLCellElement			    nova celija koja se umece u redak
     * @return integer 						    pozicija umetnute celije
     */
    public function add_cell(HTMLCellElement $cell = null) {
        if (null == $cell) {
            return $this->children->add(new HTMLCellElement());
        }
        return $this->children->add($cell);
    }

    /**
     * Dodaje retku vise novih celija. Ako je predani parametar prazno polje,
     * tada se dodaje samo jedna prazna celija.
     *
     * @param $cells array          			nove celije
     */
    public function add_cells($cells = array()) {
        if (empty($cells)) {
            $this->add_cell();
        } else {
            $this->add_children(new HTMLCollection($cells));
        }
    }

    /**
     * Uklanja celiju iz retka
     *
     * @param $position integer 				celija koju je potrebno ukloniti
     */
    public function remove_cell($position) {
        $this->remove_child($position);
    }
}
