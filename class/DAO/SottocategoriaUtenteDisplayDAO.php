<?php


/**
 * Description of SottocategoriaUtenteDisplayDAO
 * 
 * Questa classe DAO, permette la sincronizzazione tra gli utenti e i matching di utenti
 * Importante il valore di display
 * Se display = 1 --> L'utente proposto non verrà visualizzato dall'utente che visiona i matching
 * Se display = 0 --> L'utente proposto sarà visibile. 
 *
 * @author Alex
 */
class SottocategoriaUtenteDisplayDAO {
    private $wpdb;
    private $table;
    
    function __construct() {
        global $wpdb;
        $wpdb->prefix = 'twn_';
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix.'sottocateogorie_utenti_display';
    }
    
    /**
     * La funzione salva un utente display nel database
     * @param type $idUtente
     * @param type $idUtenteProposto
     * @return boolean
     */
    public function saveUtenteDisplay($idUtente, $idUtenteProposto){
        //Di default il display è 1, cioè non visibile
        try{
            $this->wpdb->insert(
                    $this->table,
                    array(
                        'id_utente' => $idUtente,
                        'id_utente_proposto' => $idUtenteProposto,
                        'display' => 1
                    ),
                    array('%d', '%d', '%d')
                );
                return true;
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione resituisce un oggetto utente display per un determinato utente passato come parametro
     * @param type $idUtente
     * @return boolean
     */
    public function getUtentiDisplay($idUtente){
        try{
            $query = "SELECT * FROM ".$this->table." WHERE id_utente = ".$idUtente;
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione resituisce il valore di display dato un utente e un utente proposto
     * @param type $idUtente
     * @param type $idUtenteProposto
     * @return boolean
     */
    public function getDisplay($idUtente, $idUtenteProposto){
        try{
            $query = "SELECT display FROM ".$this->table." WHERE id_utente = ".$idUtente." AND id_utente_proposto = ".$idUtenteProposto;
            return $this->wpdb->get_var($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione restituisce tutti gli utenti rimossi (con display = 1) di un determinato utente passato per parametro
     * @param type $idUtente
     * @return boolean
     */
    public function getRimossi($idUtente){
        try{
            $query = "SELECT DISTINCT id_utente_proposto FROM ".$this->table." WHERE id_utente = ".$idUtente." AND display = 1 ORDER BY id_utente_proposto ASC";
            //echo $query;
            return $this->wpdb->get_results($query);
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    

}
