<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SottocategoriaController
 *
 * @author Alex
 */
class SottocategoriaController {
    private $DAO; //DAO da sottocagoria
    private $appartenenzaDAO; //DAO dall'associazione di sottocategoria e utente di appartenenza
    private $preferiteDAO; //DAO dall'associazione di sottocategoria e utente favorita
    private $displayDAO; 
    
    function __construct() {
        $this->DAO = new SottocategoriaDAO();
        $this->appartenenzaDAO = new SottocategoriaUtenteDAO('appartenenza');
        $this->preferiteDAO = new SottocategoriaUtenteDAO('preferite');
        $this->displayDAO = new SottocategoriaUtenteDisplayDAO();
    }
    
    /**
     * La funzione controlla se una sottocategoria non sia già presente nel database
     * e in caso non ci sia la salva, altrimenti no
     * @param Sottocategoria $s
     * @return boolean
     */
    public function saveSottocategoria(Sottocategoria $s){
        if($this->DAO->isSottocategoriaAlreadyIn($s) == false){
            $this->DAO->saveSottocategoria($s);
            return true;
        }
        return false;
    }
    
    
    public function saveSottoCategoriaUtente($idSottoCategoria, $idUtente, $tipo){
        //tipo identifica se si tratta di appartenenza ('a') o di preferite ('p')
        if($tipo == 'a'){
            return $this->appartenenzaDAO->saveSottocategoriaUtente($idSottoCategoria, $idUtente);
        }
        else{
            return $this->preferiteDAO->saveSottocategoriaUtente($idSottoCategoria, $idUtente);
        }
    }
    
    
    public function deleteSottoCategoriaByUtente($idUtente, $tipo){
        if($tipo == 'a'){
            return $this->appartenenzaDAO->deleteSottocategoriaByUtente($idUtente);
        }
        else{
            return $this->preferiteDAO->deleteSottocategoriaByUtente($idUtente);
        }
    }
    
    
    /**
     * La funzione restituisce un array di Sottocategorie 
     * Se parameters == null, la funzione restituisce tutte le sottocategorie presenti nel db
     * Se parameters == parameters['macroCategoria'], la funzione restituisce le sottocategorie di una determinata macro categoria 
     * @param type $parameters
     * @return array
     */
    public function getSottocategorie($parameters){        
        $temp = $this->DAO->getSottocategorie($parameters);
        $result = array();        
        if($temp != null){
            foreach($temp as $item){
                $s = new Sottocategoria();
                $s->setID($item->ID);
                $s->setNome(stripslashes($item->nome));
                $s->setNomeMacroCategoria(stripslashes($item->nome_macro_categoria));
                array_push($result, $s);
            }
        }
        
        return $result;        
    }
    
    /**
     * La funzione screma le sottocategorie scelte da un determinato utente, suddividendole per 
     * sottocategoria selezionata e non selezionata
     * @param type $idUtente
     * @return array
     */
    public function getSottocategorieByUtente($idUtente, $tipo){
        //La funzione deve scremare le sottocategorie selezionate da un utente
        //tipo identifica se si tratta di appartenenza ('a') o di preferite ('p')
        $result = array();
        $selezionate = array();
        $nonSelezionate = array();
        
        //ottengo gli id delle sottocategorie di un determinato utente
        $ids = array();
        $temp1 = null;
        if($tipo == 'a'){
            $temp1 = $this->appartenenzaDAO->getSottocategorie($idUtente);
        }
        else{
            $temp1 = $this->preferiteDAO->getSottocategorie($idUtente);
        }
        if($temp1 != null && count($temp1) > 0){
            foreach($temp1 as $t1){
                array_push($ids, $t1->id_sottocategoria);
            }
        }
        
        //ottengo le sottocategorie
        $temp2 = $this->DAO->getSottocategorie(null);
        if($temp2 != null && count($temp2) > 0){
            foreach($temp2 as $t2){
                $s = new Sottocategoria();
                $s->setID($t2->ID);
                $s->setNome($t2->nome);
                $s->setNomeMacroCategoria($t2->nome_macro_categoria);
                $trovato = false;
                //ciclo all'interno degli id ottenuti per un utente
                for($i=0; $i < count($ids); $i++){
                    if($s->getID() == $ids[$i]){
                        //se trovo l'id allora la sottocategoria indicata è stata scelta dall'utente
                        $trovato = true;
                        break;
                    }
                }
                if($trovato == true){
                    array_push($selezionate, $s);
                }
                else{
                    array_push($nonSelezionate, $s);
                }                
            }                
        }  
        $result['selezionate'] = $selezionate;
        $result['non-selezionate'] = $nonSelezionate;
        
        return $result;
    }
    
    /**
     * La funzione restituisce tutti gli utenti che hanno selezionato la sottocategoria passata per id
     * @param type $idSottoCategoria
     * @return array
     */
    public function getUtentiBySottocategoria($idSottoCategoria, $tipo){
        //tipo identifica se è di appartenenza ('a') o preferite ('p')
        $utenti = array();
        $temp = null;
        if($tipo == 'a'){
            $temp = $this->appartenenzaDAO->getUtenti($idSottoCategoria);
        }
        else{
            $temp = $this->preferiteDAO->getUtenti($idSottoCategoria);
        }
        
        if($temp != null && count($temp) > 0){
            foreach($temp as $item){
                array_push($utenti, $item->id_utente);
            }
        }
        return $utenti;
    }
    
    
    public function deleteSottocategoria($id){
        //per eliminare una sottocategoria, devo prima eliminare anche tutte le associazioni
        if($this->appartenenzaDAO->deleteSottocategoria($id) && $this->preferiteDAO->deleteSottocategoria($id)){
            return $this->DAO->deleteSottocategoria($id);
        }
        return false;
    }
    
    /**
     * La funzione controlla se una determinata sottocategoria è assegnata ad un determinato utente
     * @param type $idUtente
     * @param type $idSottoCategoria
     * @param type $tipo
     * @return type
     */
    public function isSottoCategoriaAssignedToUtente($idUtente, $idSottoCategoria, $tipo){
        if($tipo == 'a'){
            return $this->appartenenzaDAO->isSottoCategoriaAssignedToUtente($idSottoCategoria, $idUtente);
        }
        else{
            return $this->preferiteDAO->isSottoCategoriaAssignedToUtente($idSottoCategoria, $idUtente);
        }
    }
    
    public function matchingByUtente($idUtente){
        //La modalità per il matching è la seguente
        //1. Dall'ID utente ottengo tutte le sottocategorie di preferenza indicate dall'utente
        //2. Ciclando sugli id ottenuti, trovo gli utenti di appartenenza
        //3. Scremo gli utenti trovati eliminando i doppi, gli amici e se stessi
        //4. Scremo ulteriormente eliminando gli utenti rimossi dalla visualizzazione 
        
        $result = array();
        
        //1. Ottengo le sottocategorie preferite di un utente
        $preferite = $this->preferiteDAO->getSottocategorie($idUtente);
                        
        if($preferite == null){
            return $result;
        }
        
        //2. Ciclo sulle sottocategorie
        $utenti = array();
        foreach($preferite as $preferita){
            
            $users = $this->appartenenzaDAO->getUtenti($preferita->id_sottocategoria);
                      
            if(count($users) > 0){
                foreach($users as $user){
                    array_push($utenti, $user->id_utente);
                }
            }
        }
        
        
        //3. scremo gli ottenuti
        $result = array_unique($utenti);
        
        //tolgo gli amici
        $friends = friends_get_friend_user_ids($idUtente);
        //print_r($friends);
        if(count($friends)  > 0){  
            //scremo
            $result = $this->removeElementsFromArray($result, $friends);            
        } 
        
        //4. scremo togliendo i rimossi dalla visualizzazione
        $temp = $this->displayDAO->getRimossi($idUtente);
        if($temp != null && count($temp) > 0){
            $rimossi = array();
            foreach($temp as $t){
                array_push($rimossi, $t->id_utente_proposto);
            } 
            //scremo
            $result = $this->removeElementsFromArray($result, $rimossi);            
        }
       
        return $result;        
    }
    
    /**
     * Funzione che toglie da un array gli elementi presenti un un secondo array passato per parametro
     * @param boolean $array
     * @param type $remove
     * @return array
     */
    private function removeElementsFromArray($array, $remove){
        $result = array();
        for($i=0; $i < count($array); $i++){
            for($j=0; $j < count($remove); $j++ ){                    
                if($array[$i] == $remove[$j]){                        
                    $array[$i] = false;
                }
            }
        }
        
        for($i=0; $i < count($array); $i++){
            if($array[$i] != false){
                array_push($result, $array[$i]);
            }
        }
        
        return $result;
    }
    
    
    /**
     * La funzione inizia il percorso di rimozione dalla visualizzazione di un determinato
     * utente, un determinato utente proposto, salvandolo in una tabella del database apposita
     * @param type $idUtente
     * @param type $idUtenteProposto
     * @return type
     */
    public function removeProposto($idUtente, $idUtenteProposto){
        return $this->displayDAO->saveUtenteDisplay($idUtente, $idUtenteProposto);
    }
    
    /**
     * La funzione restituisce tutti gli utenti proposti rimossi di un determinato utente
     * passato per parametro
     * @param type $idUtente
     * @return array
     */
    public function getUtentiPropostiRimossi($idUtente){
        $utenti = array();
        $temp = $this->displayDAO->getUtentiDisplay($idUtente);
        
        foreach($temp as $t){
            array_push($utenti, $t->id_utente_proposto);
        }
        
        return $utenti;
    }

}
