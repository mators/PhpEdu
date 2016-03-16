<?php

namespace app\oipa\view;


/**
 * Apstraktni razred oblikovnog obrasca Okvirna metoda.
 * Cilj razreda jest nadograditi metodu za ispis html koda stranice.
 */
abstract class AbstractView implements View {

    /**
     * Konstruktor.
     * Moguće je proslijediti ime parametra čija vrijednost se želi postaviti.
     * Ukoliko postoji setter za navedeni atribut, isti se postavlja na 
     * vrijednost koju ključ u nizu ima.
     * @param array $array niz ključ-vrijednost kojim se želi 
     * inicijalizirati vrijednosti objekta
     */
    public function __construct(array $array = array()) {
        foreach ($array as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Ispis svog teksta upisanog s echo i sličnim funkcijama.
     * @return type
     */
    public function render() {
        //paljenje output bufferinga
        ob_start();
        
        $this->outputHTML();
        
        //dohvati trenutno stanje buffera i isprazni ga
        return ob_get_clean();
    }

    /**
     * HTML opis stranice.
     */
    protected abstract function outputHTML();

    public function __toString() {
        return $this->render();
    }

}
