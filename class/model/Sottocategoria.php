<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sottocategoria
 *
 * @author Alex
 */
class Sottocategoria {
    //put your code here
    private $ID;
    private $nome;
    private $nomeMacroCategoria;
    private $utenti;
    
    function __construct() {
        
    }
    
    function getID() {
        return $this->ID;
    }

    function getNome() {
        return $this->nome;
    }

    function getNomeMacroCategoria() {
        return $this->nomeMacroCategoria;
    }

    function getUtenti() {
        return $this->utenti;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNomeMacroCategoria($nomeMacroCategoria) {
        $this->nomeMacroCategoria = $nomeMacroCategoria;
    }

    function setUtenti($utenti) {
        $this->utenti = $utenti;
    }



}
