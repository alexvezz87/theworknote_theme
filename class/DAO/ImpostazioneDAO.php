<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImpostazioneDAO
 *
 * @author Alex
 */
class ImpostazioneDAO {
    private $wpdb;
    private $table;
    
    function __construct() {
        global $wpdb;
        $wpdb->prefix = 'twn_';
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix.'impostazioni';
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
     * La funzione salva un impostazione nel database
     * @param Impostazione $i
     * @return type
     */
    public function saveImpostazione(Impostazione $i){
        try{
            $this->wpdb->insert(
                $this->table,
                array(
                    'nome' => $i->getNome(),
                    'valore' => $i->getValore()
                ),
                array('%s', '%s')
            );
            return $this->wpdb->insert_id;
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione restituisce tutte le impostazioni
     * @return boolean
     */
    public function getImpostazioni(){
        try{
            $query = "SELECT * FROM ".$this->table;            
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione restituisce il valore di un'impostazione passandole il nome
     * @param type $nome
     * @return boolean
     */
    public function getImpostazioneByNome($nome){
        try{
            $query = "SELECT valore FROM ".$this->table." WHERE nome = '".$nome."'";
            
            return $this->wpdb->get_var($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    
    /**
     * La funzione cancella un'impostazione dal database
     * @param type $id
     * @return boolean
     */    
    public function deleteImpostazione($id){
        try{
            $this->wpdb->delete($this->table, array('ID' => $id));
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * LA funzione aggiorna un'impostazione nel database
     * @param Impostazione $i
     * @return boolean
     */
    public function updateImpostazione(Impostazione $i){
        try{
            $this->wpdb->update(
                    $this->table,
                    array('valore' => $i->getValore()),
                    array('ID' => $i->getID()),
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
