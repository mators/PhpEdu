<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja table element.
 */
class HTMLTableElement extends HTMLElement {


    public function __construct($rows = [])
    {
        parent::__construct("table");
        if (!is_array($rows)) {
            throw new \InvalidArgumentException("rows - array expected");
        }
        $this->children = new HTMLCollection($rows);
    }

    /**
     * Dodaje novi redak tablice. Ako je predani parametar jednak 'null',
     * tada se dodaje novi prazan redak tablice.
     *
     * @param $row HTMLRowElement				novi redak koji se dodaje
     * @return integer 						    pozicija umetnutog retka
     */
    public function add_row(HTMLRowElement $row = null) {
        if (null == $row) {
            return $this->children->add(new HTMLRowElement());
        }
        return $this->children->add($row);
    }

    /**
     * Dodaje vise novih redaka tablice. Ako je predani parametar prazno polje,
     * tada se dodaje samo jedan prazan redak.
     *
     * @param $rows array         				novi retci koje je potrebno umetnuti
     */
    public function add_rows($rows = array()) {
        if (empty($cells)) {
            $this->add_row();
        } else {
            $this->add_children(new HTMLCollection($rows));
        }
    }

    /**
     * Uklanja redak iz tablice
     *
     * @param $position integer 				redak koji je potrebno ukloniti
     */
    public function remove_row($position) {
        $this->remove_child($position);
    }
}
