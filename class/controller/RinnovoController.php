<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RinnovoController
 *
 * @author Alex
 */
class RinnovoController {
   
    private $DAO;
    
    function __construct() {
        $this->DAO = new RinnovoDAO();
    }
    
  
    /**
     * La funzione rinnova un utente nel database
     * Distingue i due casi in cui bisogna inserirlo o aggiornarlo
     * @param type $idUtente
     * @return type
     */
    public function rinnovaUtente($idUtente){
        
        $r = new Rinnovo();
        $r->setIdUtente($idUtente);
        $rinnovato = $this->DAO->isRinnovato($idUtente);
        if($rinnovato == false){
            //se non lo trovo, lo aggiungo salvandolo            
            return $this->DAO->saveRinnovo($r);
        }
        else{
            //se lo trovo lo aggiorno
            $r->setID($rinnovato);
            return $this->DAO->updateRinnovo($r);
        }
    }
    
    /**
     * La funzione restituisce vero o falso a seconda se un utente ha rinnovato l'utenza
     * @param type $idUtente
     * @return boolean
     */
    public function isRinnovato($idUtente){
        if($this->DAO->isRinnovato($idUtente) == false){
            return false;
        }
        return true;
    }
    
    /**
     * La funzione restituisce la data di rinnovo
     * @param type $idUtente
     * @return type
     */
    public function getDataRinnovo($idUtente){
        return $this->DAO->getDataRinnovo($idUtente);
    }
   
    
    

}
