<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentoController
 *
 * @author Alex
 */
class CommentoController {
    private $DAO;
    
    function __construct() {
        $this->DAO = new CommentoDAO();
    }
    
    
    /**
     * La funzione salva un commento
     * @param Commento $c
     * @return type
     */
    public function saveComment(Commento $c){
        return $this->DAO->saveComment($c);
    }
    
    /**
     * La funzione effettua una query al db e restituisce un array di oggetti commento
     * @param type $idUser
     * @return boolean|array
     */
    public function getCommentsFromUserPage($idUser){
        //La funzione deve restituire un array di oggetti commento
        
        try{
            $commenti = array();
            $temp = $this->DAO->getCommentsFromUserPage($idUser);

            foreach($temp as $item){
                $commento = new Commento();
                $commento->setID($item->ID);
                $commento->setIdCommentedUser($item->id_commented_user);
                $commento->setIdCommentingUser($item->id_commenting_user);
                $commento->setCommentDate($item->comment_date);
                $commento->setCommentText(stripslashes($item->comment_text));
                $commento->setCommentLikes($item->comment_likes);

                array_push($commenti, $commento);
            }

            return $commenti;
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }        
    }
    
    public function getCommentsByAjax($idUser){
        //La funzione deve restituire un array di oggetti commento
        
        try{            
            return $this->DAO->getCommentsFromUserPage($idUser);           
        } catch (Exception $ex) {
            _e($ex);
            return false;
        }        
    }
    
    /**
     * Aggiorna il commento
     * @param Commento $c
     * @return type
     */
    public function updateComment(Commento $c){
        return $this->DAO->updateCommentText($c);
    }
    
    /**
     * La funzione aumenta i like di un determinato commento
     * @param Commento $c
     * @return type
     */
    public function increaseLikes(Commento $c){
        $c->setCommentLikes($c->getCommentLikes()+1);
        return $this->DAO->updateCommentLikes($c);
    }
    
    /**
     * La funzione decrementa i like di un determinato commento
     * @param Commento $c
     * @return boolean
     */
    public function decreaseLikes(Commento $c){
        if($c->getCommentLikes() > 0){
            $c->setCommentLikes($c->getCommentLikes()-1);
            return $this->DAO->updateCommentLikes($c);
        }
        return false;
    }
        
    /**
     * La funzione controlla se un utente può editare il commento.
     * Chi può editare il commento sono: l'autore del commento, il proprietario della pagina.
     * @param type $idComment
     * @param type $idUser
     * @return boolean
     */
    public function canEdit($idComment, $idUser){
        //controllo se posso modificare
        $commento = $this->DAO->getCommentByID($idComment);        
        if($commento->id_commented_user == $idUser || $commento->id_commenting_user == $idUser){
            return true;
        }
        return false;        
    }
    
    public function deleteComment($idComment){
        return $this->DAO->deleteComment($idComment);
    }

}
