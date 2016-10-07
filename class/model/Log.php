<?php


/**
 * Description of Log
 *
 * @author Alex
 */
class Log {
    
    private $ID;
    private $mittente;
    private $destinatario;
    private $tipo;
    private $dataLog;
    
    function __construct() {
        
    }
    
    function getID() {
        return $this->ID;
    }

    function getMittente() {
        return $this->mittente;
    }

    function getDestinatario() {
        return $this->destinatario;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setMittente($mittente) {
        $this->mittente = $mittente;
    }

    function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getDataLog() {
        return $this->dataLog;
    }

    function setDataLog($dataLog) {
        $this->dataLog = $dataLog;
    }



}
