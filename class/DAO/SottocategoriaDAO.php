<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SottocategoriaDAO
 *
 * @author Alex
 */
class SottocategoriaDAO {
    private $wpdb;
    private $table;
    
    function __construct() {
        global $wpdb;
        $wpdb->prefix = 'twn_';
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix.'sottocategorie';
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
     * La funzione salva una sottocategoria nel database
     * @param Sottocategoria $s
     * @return type
     */
    function saveSottocategoria(Sottocategoria $s){
        try{
            $this->wpdb->insert(
                    $this->table,
                    array(
                        'nome' => $s->getNome(),
                        'nome_macro_categoria' => $s->getNomeMacroCategoria()
                    ),
                    array('%s', '%s')
                );
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione restituisce le sottocategorie dati determinati parametri
     * @param type $nomeMacroCategoria
     * @return type
     */
    function getSottocategorie($parameters){
                
        try{
            $query = "SELECT * FROM ".$this->table." WHERE 1=1";
            if($parameters != null && isset($parameters['macroCategoria'])){
                $query.= " AND nome_macro_categoria = '".$parameters['macroCategoria']."'";
            } 
            
            
            if($parameters != null && isset($parameters['order'])){
                $query.= " ORDER BY ".$parameters['order']." ASC";
            }
            
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    
    /**
     * La funzione aggiorna una sottocategoria
     * @param Sottocategoria $s
     * @return boolean
     */
    function updateSottocategoria(Sottocategoria $s){
        try{
            $this->wpdb->update(
                    $this->table,
                    array(
                        'nome' => $s->getNome(),
                        'nome_macro_categoria' => $s->getNomeMacroCategoria()
                    ),
                    array('ID' => $s->getID()),
                    array('%s', '%s'),
                    array('%d')
                );
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione elimina una sottocategoria dal database
     * @param type $id
     * @return boolean
     */
    function deleteSottocategoria($id){
        try{
            $this->wpdb->delete($this->table, array('ID' => $id));
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione controlla se esiste già nel database un'occorrenza di una sottocategoria
     * Restituisce true se la trova, false in caso contrario
     * @param Sottocategoria $s
     * @return boolean
     */
    public function isSottocategoriaAlreadyIn(Sottocategoria $s){
        try{
            $query = "SELECT ID FROM ".$this->table." WHERE nome = '".$s->getNome()."' AND nome_macro_categoria = '".$s->getNomeMacroCategoria()."'";
            $result = $this->wpdb->get_results($query);
            if($result == null){
                return false;
            }
            return true;            
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    

}
