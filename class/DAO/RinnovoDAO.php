<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RinnovoDAO
 *
 * @author Alex
 */
class RinnovoDAO {
    
    private $wpdb;
    private $table;
    
    function __construct() {
        global $wpdb;
        $wpdb->prefix = 'twn_';
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix.'rinnovi';
    }
    
    function getWpdb() {
        return $this->wpdb;
    }

    function getTable() {
        return $this->table;
    }

    function setWpdb($wpdb) {
        $this->wpdb = $wpdb;
    }

    function setTable($table) {
        $this->table = $table;
    }

    /**
     * Salvo un rinnovo nel db
     * @param Rinnovo $r
     * @return type
     */
    public function saveRinnovo(Rinnovo $r){
        try{
            //imposto il timezone
            date_default_timezone_set('Europe/Rome');
            $timestamp = date('Y-m-d H:i:s', strtotime("now"));
            $this->wpdb->insert(
                    $this->table,
                    array(
                        'id_utente' => $r->getIdUtente(),
                        'data_rinnovo' => $timestamp
                    ),
                    array('%d', '%s')
                );
            return $this->wpdb->insert_id;            
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione controlla se un idUtente è presente nella tabella rinnovati
     * Se non è presente restituisce false, altrimenti resituisce l'ID del record ricercato
     * @param type $idUtente
     * @return boolean
     */
    public function isRinnovato($idUtente){
        try{
            $query = "SELECT ID FROM ".$this->table." WHERE id_utente = ".$idUtente;
            $result = $this->wpdb->get_var($query);
            if($result == null){
                return false;
            }
            return $result;
            
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * Funzione che restituisce un rinnovo passato l'ID
     * @param type $ID
     * @return type
     */
    public function getRinnovo($ID){
        try{
            $query = "SELECT * FROM ".$this->table." WHERE ID = ".$ID;
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione restituisce una data rinnovo di un utente
     * @param type $idUtente
     * @return type
     */
    public function getDataRinnovo($idUtente){
        try{
            $query = "SELECT data_rinnovo FROM ".$this->table." WHERE id_utente = ".$idUtente;
            return $this->wpdb->get_var($query);
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione aggiorna la data di un rinnovo
     * @param Rinnovo $r
     * @return boolean
     */
    public function updateRinnovo(Rinnovo $r){
        try{
            //imposto il timezone
            date_default_timezone_set('Europe/Rome');
            $timestamp = date('Y-m-d H:i:s', strtotime("now"));
            $this->wpdb->update(
                    $this->table,
                    array('data_rinnovo' => $timestamp),
                    array('ID' => $r->getID()),
                    array('%s'),
                    array('%d')
                );
            return true;
                    
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    
    

}
