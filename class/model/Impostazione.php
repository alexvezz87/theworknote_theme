<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Impostazione
 *
 * @author Alex
 */
class Impostazione {
    
    private $nome;
    private $valore;
    private $ID;
    
    function __construct() {
        //costruttore vuoto
    }
    
    function getNome() {
        return $this->nome;
    }

    function getValore() {
        return $this->valore;
    }

    function getID() {
        return $this->ID;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setValore($valore) {
        $this->valore = $valore;
    }

    function setID($ID) {
        $this->ID = $ID;
    }



}
