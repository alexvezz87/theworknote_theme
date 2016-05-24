<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImpostazioneController
 *
 * @author Alex
 */
class ImpostazioneController {
    private $DAO;
    
    function __construct() {
        $this->DAO = new ImpostazioneDAO();
    }

    
    function getDAO() {
        return $this->DAO;
    }

    function setDAO($DAO) {
        $this->DAO = $DAO;
    }
    
    
    /**
     * La funzione salva una impostazione
     * @param Impostazione $i
     * @return type
     */
    public function saveImpostazione(Impostazione $i){
        return $this->DAO->saveImpostazione($i);
    }
    
    
    /**
     * La funzione restituisce un array di oggetti impostazione 
     * @return boolean|array
     */
    public function getImpostazioni(){        
        try{
            $impostazioni = array();
            $temp = $this->DAO->getImpostazioni();

            
            foreach($temp as $item){
                $impostazione = new Impostazione();
                $impostazione->setID($item->ID);
                $impostazione->setNome($item->nome);
                $impostazione->setValore($item->valore);

                array_push($impostazioni, $impostazione);
            }
           
            return $impostazioni;
        } catch(Exception $ex){
            _e($ex);
            return false;
        }        
    }
    
    /**
     * La funzione restituisce il valore di un'impostazione passata per nome
     * @param type $nome
     * @return type
     */
    public function getImpostazioneByNome($nome){
        return $this->DAO->getImpostazioneByNome($nome);
    }
    
    /**
     * La funzione aggiorna un'impostazione
     * @param Impostazione $i
     * @return type
     */
    public function updateImpostazione(Impostazione $i){
        return $this->DAO->updateImpostazione($i);
    }
    
    /**
     * La funzione cancella un'impostazione
     * @param type $id
     * @return type
     */
    public function deleteImpostazione($id){
        return $this->DAO->deleteImpostazione($id);
    }
    

}
