<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentoView
 *
 * @author Alex
 */
class CommentoView {
    
    private $controller; 
    
    function __construct() {
        $this->controller = new CommentoController();
    }
    
    /**
     * La funzione stampa il form di inserimento commento
     * @param type $UserPageID
     */
    public function printCommentForm($UserPageID){
        //current user
        $current_user = wp_get_current_user();
        $user_info = get_userdata($UserPageID);
        $img = bp_core_fetch_avatar(  array( 'item_id' => $current_user->ID, 'html' => false ) );
        
        if(is_user_logged_in ()){
    ?>
            <div id="comment-container" class="comment-container">
                <div class="comment-header">
                    <img src="<?php echo $img ?>">
                    <span>Lascia un commento a <?php echo $user_info->display_name ?></span>
                </div>
                <div class="comment-text">
                    <textarea name="comment-text" cols="50" rows="10"></textarea>
                </div>
                <div class="comment-submit">
                    <input type="hidden" name="url" value="<?php echo get_home_url().'/wp-admin/admin-ajax.php' ?>" />
                    <input type="hidden" name="id-user-commenting" value="<?php echo $current_user->ID ?>" />
                    <input type="hidden" name="id-user-commented" value="<?php echo $UserPageID ?>" />
                    <input type="button" name="submit-button" value="Invia Commento" />
                </div>
                
            </div>

    <?php
        } 
    }
    
    public function printCommentList($UserPageID){
        //ottengo tutti i commenti
        $commenti = $this->controller->getCommentsFromUserPage($UserPageID);
        
        if(count($commenti) > 0){
            foreach($commenti as $item){
                $c = new Commento();
                $c = $item;
                $user_info = get_userdata($c->getIdCommentingUser());            
                $img = bp_core_fetch_avatar(  array( 'item_id' => $c->getIdCommentingUser(), 'html' => false ) );
                $current_user = wp_get_current_user();
            
    ?>        
            <div class="container-commento">
                <?php if(is_user_logged_in () && $this->controller->canEdit($c->getID(), $current_user->ID)) { ?>
                <a class="elimina-commento">X</a>
                <input type="hidden" name="id" value="<?php echo $c->getID() ?>" />                               
                <?php } ?>
                <div class="header-commento">
                    <a href="<?php echo home_url().'/members/'.$user_info->user_login; ?>"><img alt="<?php echo $user_info->display_name ?>" src="<?php echo $img ?>" /></a>
                    <a href="<?php echo home_url().'/members/'.$user_info->user_login; ?>"><span class="nome"><?php echo $user_info->display_name ?></span></a>
                    <span class="time"><?php echo showCustomTime2($c->getCommentDate()) ?></span>
                </div>
                <div class="comment-text"><?php echo $c->getCommentText() ?></div>
            </div>
    <?php
            }
        }
        else{
    ?>
            <p>Non ci sono commenti da visualizzare</p>
    <?php
        }
    }
    

}
