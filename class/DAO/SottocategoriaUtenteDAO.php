<?php

/**
 * Description of SottocategoriaUtenteDAO
 *
 * @author Alex
 */
class SottocategoriaUtenteDAO {
    private $wpdb;
    private $table;
    
    function __construct($tipo) {
        global $wpdb;
        $wpdb->prefix = 'twn_';
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix.'sottocategorie_utenti_'.$tipo;
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
     * La funzione salva un'associazione tra untente e sottocategoria nel database
     * @param type $idSottoCategoria
     * @param type $idUtente
     * @return type
     */
    public function saveSottocategoriaUtente($idSottoCategoria, $idUtente){
        try{
            $this->wpdb->insert(
                    $this->table,
                    array(
                        'id_utente' => $idUtente,
                        'id_sottocategoria' => $idSottoCategoria
                    ),
                    array('%d', '%d')
                );
            return $this->wpdb->insert_id;
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione restituisce una lista di sottocategorie conoscendo l'utente
     * @param type $idUtente
     * @return boolean
     */
    public function getSottocategorie($idUtente){
        try{
            $query = "SELECT id_sottocategoria FROM ".$this->table." WHERE id_utente = ".$idUtente;
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione restituisce una lista di Utenti conoscendo la sottocategoria
     * @param type $idSottoCategoria
     * @return boolean
     */
    public function getUtenti($idSottoCategoria){
        try{
            $query = "SELECT id_utente FROM ".$this->table." WHERE id_sottocategoria = ".$idSottoCategoria. " ORDER BY id_utente ASC";
            
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione elimina le occorrenze di una sottocategoria passata per id
     * @param type $idSottocategoria
     * @return boolean
     */
    public function deleteSottocategoria($idSottocategoria){
        try{
            $this->wpdb->delete($this->table, array('id_sottocategoria' => $idSottocategoria));
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione elimina tutte le occorrenze di sottocategorieUtente di un determinato utente
     * @param type $idUtente
     * @return boolean
     */
    public function deleteSottocategoriaByUtente($idUtente){
        try{
            $this->wpdb->delete($this->table, array('id_utente' => $idUtente));
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * Controlla se la sottocategoria passata per parametro è assegnata ad un utente
     * 
     * @param type $idSottoCategoria
     * @param type $idUtente
     * @return boolean
     */
    public function isSottoCategoriaAssignedToUtente($idSottoCategoria, $idUtente){
        try{
            $query = "SELECT ID FROM ".$this->table." WHERE id_utente = ".$idUtente." AND id_sottocategoria = ".$idSottoCategoria;
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
    
    /**
     * LA funzione controlla se un utente è presente nella tabella
     * @param type $idUtente
     * @return boolean
     */
    public function isUtenteInTabella($idUtente){
        try{
            $query = "SELECT ID FROM ".$this->table." WHERE id_utente = ".$idUtente;
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
