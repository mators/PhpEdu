<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Predstavlja kolekciju HTML cvorova.
 */
class HTMLCollection {

    /**
     * Polje cvorova koji su dio kolekcije
     * @var array
     */
    private $nodes;

    /**
     * Stvara novu kolekciju i puni je cvorovima ako je barem,
     * predan metodi. Pozicija svakog umetnutog cvora odgovara
     * poziciji cvora u predanom polju.
     *
     * @param array $nodes					polje cvorova koje je potrebno ubaciti u kolekciju
     */
    public function __construct($nodes = array()) {
        if (!is_array($nodes)) {
            throw new \InvalidArgumentException("nodes - array expected");
        }
        $this->nodes = $nodes;
    }

    /**
     * Umece novi cvor u kolekciju cvorova. Cvor se umece na
     * kraj polja, tako da njegovo mjesto uvijek odgovara
     * do tada umetnutom broju cvorova.
     *
     * @param HTMLNode $node                    cvor koji je potrebno umetnuti
     * @return integer                          mjesto unutar kolekcije na koje je cvor umetnut
     */
    public function add(HTMLNode $node) {
        array_push($this->nodes, $node);
        end($this->nodes);
        return key($this->nodes);
    }

    /**
     * Dohvaca cvor kolekcije s tocno odredjene pozicije
     *
     * @param integer $position				    pozicija cvora koji je potrebno dohvatiti
     * @return HTMLNode 						cvor s trazene pozicije
     */
    public function get($position) {
        if(!is_integer($position)) {
            throw new \InvalidArgumentException("position - integer expected");
        }
        if(!array_key_exists($position, $this->nodes)) {
            throw new \InvalidArgumentException("not valid position");
        }
        return $this->nodes[$position];
    }

    /**
     * Vraca sve elemente kolekcije.
     *
     * @return array							elementi kolekcije
     */
    public function get_all() {
        return $this->nodes;
    }

    /**
     * Uklanja element na zadanoj poziciji.
     *
     * @param $position integer                pozicija elementa
     */
    public function remove($position) {
        if(!is_integer($position)) {
            throw new \InvalidArgumentException("position - integer expected");
        }
        if(!array_key_exists($position, $this->nodes)) {
            throw new \InvalidArgumentException("not valid position");
        }
        unset($this->nodes[$position]);
    }

    /**
     * Vraca informaciju o velicini kolekcije.
     *
     * @return integer  						broj elemenata kolekcije
     */
    public function size() {
        return count($this->nodes);
    }

    public function __toString() {
        return implode("", $this->nodes);
    }
}
