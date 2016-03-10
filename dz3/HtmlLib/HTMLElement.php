<?php

namespace hr\sofascore\dz3\htmllib;


/**
 * Genericka implementacija HTML elementa.
 */
class HTMLElement extends HTMLNode {

    /**
     * Polje atributa koji pripadaju elementu
     * @var array
     */
    protected $attributes;

    /**
     * Djeca HTML elementa
     * @var HTMLCollection
     */
    protected $children;

    /**
     * Zastavica koja oznacava ima li otvarajuci tag i pripadajuci
     * zatvarajuci tag.
     * @var bool
     */
    protected $closed;

    /**
     * Naziv HTML elementa
     * @var string
     */
    protected $name;

    /**
     * Stvara novi element zadanog naziva uz posvecivanje
     * paznje na otvarajuce i zatvarajuce tagove.
     *
     * @param $name string                      ime elementa
     * @param $closed bool                      oznaka za zatvarajuci tag
     * @param $children HTMLCollection        djeca elementa
     */
    public function __construct($name, $closed = true, HTMLCollection $children = null) {
        if (!is_string($name)){
            throw new \InvalidArgumentException("name - string expected");
        }
        if (!is_bool($closed)) {
            throw new \InvalidArgumentException("closed - bool expected");
        }
        if (null == $children) {
            $this->children = new HTMLCollection();
        } else {
            $this->children = $children;
        }
        $this->attributes = [];
        $this->name = $name;
        $this->closed = $closed;
    }

    /**
     * Elementu dodaje novo dijete.
     *
     * @param $node HTMLNode					novo dijete
     * @return integer 						    pozicija dodanog djeteta unutar polje djece
     */
    public function add_child(HTMLNode $node) {
        return $this->children->add($node);
    }

    /**
     * Elementu dodaje cijelu kolekciju elemenata koji ce biti njegova
     * djeca.
     *
     * @param $collection HTMLCollection		kolekcija elemenata koja predstavlja djecu
     */
    public function add_children(HTMLCollection $collection) {
        $this->children = $collection;
    }

    /**
     * Vraca dijete koje se nalazi na zadanoj poziciji.
     *
     * @param $position integer                 pozicija
     * @return HTMLNode                         dijete na zadanoj poziciji
     */
    public function get_child($position) {
        return $this->children->get($position);
    }

    /**
     * Vraca trenutni broj djece elementa.
     *
     * @return integer						    broj djece elementa
     */
    public function get_children_number() {
        return $this->children->size();
    }

    /**
     * Uklanje dijete koje se nalazi na poziciji odredjenoj parametrom.
     *
     * @param $position integer				    pozicija na kojoj se nalazi dijete koje je potrebno ukloniti
     */
    public function remove_child($position) {
        $this->children->remove($position);
    }

    /**
     * Obavlja dodavanje novog atributa.
     *
     * @param $attribute HTMLAttribute  		novi atribut elementa
     */
    public function add_attribute(HTMLAttribute $attribute) {
        array_push($this->attributes, $attribute);
    }

    /**
     * Iz polja atributa uklanja atribut zadanog imena.
     *
     * @param $attribute string 				naziv atributa kojii je potrebno ukloniti
     */
    public function remove_attribute($attribute) {
        if (!is_string($attribute)) {
            throw new \InvalidArgumentException("attribute - string expected");
        }
        foreach ($this->attributes as $key => $att) {
            if ($att->name == $attribute) {
                unset($this->attributes[$key]);
                return;
            }
        }
    }

    /**
     * Vraca naziv elementa.
     * @return string							naziv elementa
     */
    public function get_name() {
        return $this->name;
    }

    public function __toString() {
        return "<" . $this->name . " " . implode(" ", $this->attributes) . ">"
        . ($this->children ?: "") . ($this->closed ? "</" . $this->name . ">" : "");
    }
}
