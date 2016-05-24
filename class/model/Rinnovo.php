<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rinnovo
 *
 * @author Alex
 */
class Rinnovo {
    
    private $ID;
    private $idUtente;
    private $dataRinnovo;
    
    function __construct() {
        //costruttore vuoto
    }
    
    function getID() {
        return $this->ID;
    }

    function getIdUtente() {
        return $this->idUtente;
    }

    function getDataRinnovo() {
        return $this->dataRinnovo;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setIdUtente($idUtente) {
        $this->idUtente = $idUtente;
    }

    function setDataRinnovo($dataRinnovo) {
        $this->dataRinnovo = $dataRinnovo;
    }



    
}
