<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentoDAO
 *
 * @author Alex
 */
class CommentoDAO {
    private $wpdb;
    private $table;
    
    function __construct() {
        global $wpdb;
        $wpdb->prefix = 'twn_';
        $this->wpdb = $wpdb;
        $this->table = $wpdb->prefix.'comments';
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
     * La funzione salva un commento nel database
     * @param Commento $c
     * @return boolean
     */
    public function saveComment(Commento $c){
        try{
            //imposto il timezone
            date_default_timezone_set('Europe/Rome');
            $timestamp = date('Y-m-d H:i:s', strtotime("now")); 
            $this->wpdb->insert(
                    $this->table,
                    array(
                        'id_commented_user' => $c->getIdCommentedUser(),
                        'id_commenting_user' => $c->getIdCommentingUser(),
                        'comment_date' => $timestamp,
                        'comment_text' => $c->getCommentText(),
                        'comment_likes' => $c->getCommentLikes()
                    ),
                    array('%d', '%d', '%s', '%s', '%d')
                );
            //restituisco l'id del record            
            return $this->wpdb->insert_id;            
        } catch (Exception $ex) {
            _e($ex);
            return -1;
        }
    }
    
    /**
     * La funzione restituisce tutti i commenti di una determinata pagina utente
     * @param type $idUser
     * @return boolean
     */
    public function getCommentsFromUserPage($idUser){
        try{
            $query = "SELECT * FROM ".$this->table." WHERE id_commented_user = ".$idUser." ORDER BY ID DESC";
            return $this->wpdb->get_results($query);
            
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    public function getCommentByID($idComment){
        try{
            $query = "SELECT * FROM ".$this->table." WHERE ID = ".$idComment;           
            return $this->wpdb->get_row($query);            
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
           
    /**
     * La funzione elimina un determinato commento dal database
     * @param type $idComment
     * @return boolean
     */
    public function deleteComment($idComment){
        try{
            $this->wpdb->delete($this->table, array('ID' => $idComment) );
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione aggiorna il testo e il numero di un commento
     * @param Commento $c
     * @return boolean
     */
    public function updateCommentText(Commento $c){
        try{
            $this->wpdb->update(
                    $this->table,
                    array('comment_text' => $c->getCommentText()),
                    array('ID' => $c->getID()),
                    array('%s'),
                    array('%d')
                );
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    /**
     * La funzione aggiorna il numero dei like di un commento
     * @param Commento $c
     * @return boolean
     */
    public function updateCommentLikes(Commento $c){
        try{
            $this->wpdb->update(
                    $this->table,
                    array('comment_likes' => $c->getCommentLikes()),
                    array('ID' => $c->getID()),
                    array('%d'),
                    array('%d')
                );
            return true;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }
    }
    
    
    
    


}
