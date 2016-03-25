<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Commento
 *
 * @author Alex
 */
class Commento {
    //put your code here
    private $ID;
    private $idCommentedUser;
    private $idCommentingUser;
    private $commentDate;
    private $commentText;
    private $commentLikes;
    
    function __construct() {
        
    }
   
    function getID() {
        return $this->ID;
    }

    function getIdCommentedUser() {
        return $this->idCommentedUser;
    }

    function getIdCommentingUser() {
        return $this->idCommentingUser;
    }

    function getCommentDate() {
        return $this->commentDate;
    }

    function getCommentText() {
        return $this->commentText;
    }

    function getCommentLikes() {
        return $this->commentLikes;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setIdCommentedUser($idCommentedUser) {
        $this->idCommentedUser = $idCommentedUser;
    }

    function setIdCommentingUser($idCommentingUser) {
        $this->idCommentingUser = $idCommentingUser;
    }

    function setCommentDate($commentDate) {
        $this->commentDate = $commentDate;
    }

    function setCommentText($commentText) {
        $this->commentText = $commentText;
    }

    function setCommentLikes($commentLikes) {
        $this->commentLikes = $commentLikes;
    }


          
}
