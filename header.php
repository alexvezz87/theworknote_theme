<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage theworknote_theme
 * @since The Work Note 1.0
 */

//BuddyPress
global $bp;

//imposto alcuni path
$path_img = esc_url( get_template_directory_uri() ).'/images/';
$path_img_mobile = $path_img.'mobile/';
$path_js = esc_url( get_template_directory_uri() ).'/js/';
$path_css = esc_url( get_template_directory_uri() ).'/css/';

//ottengo il menu
$menu = wp_get_nav_menu_items( 'primary');

//current user
$current_user = wp_get_current_user();

$img = "";
$n_posta = 0;
$n_notifiche = 0;
$n_collab = 0;

//se esiste il current user
if($current_user->ID > 0){
    //url dell'immagine dell'avatar
    $img = bp_core_fetch_avatar(  array( 'item_id' => $current_user->ID, 'html' => false ) );
    //numero di messaggi non letti
    $n_posta = messages_get_unread_count( $current_user->ID );
    //numero di notifiche non lette
    $n_notifiche = bp_notifications_get_unread_notification_count( $current_user->ID );
    //numero di richieste di collaborazione
    $n_collab = bp_friend_get_total_requests_count($current_user->ID);            
}



//impostazione lunghezza nome utente
$max_lenght_nome = 15;


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
        <title>The Work Note - <?php echo get_the_title(get_the_ID()); ?></title>
	
	<!--[if lt IE 9]>
	<script src="<?php echo $path_js ?>html5.js"></script>
	<![endif]-->
        
       <script src="<?php echo $path_js ?>jquery-2.1.4.min.js"></script>
        <!-- swiper -->
        <link rel="stylesheet" href="<?php echo $path_css ?>swiper.min.css">   
       
        <!-- end swiper -->  
        
        <script src="<?php echo $path_js ?>jquery-2.1.4.min.js"></script>
        <script src="<?php echo $path_js ?>jquery-ui.min.js"></script>
        <script src="<?php echo $path_js ?>jquery.mobile.custom.min.js"></script>
        <script src="<?php echo $path_js ?>bootstrap.min.js"></script>    
        <script src="<?php echo $path_js ?>functions.js"></script>
       
        
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" type="text/css" >
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/style.css" type="text/css" >
        
        
        <link rel="icon" href="<?php echo $path_img ?>favicon.png" type="image/png" />
        
	<?php wp_head(); ?>
</head>
<body 
    <?php
        if($current_user->ID != 0){    
            if(is_super_admin($current_user->ID )){
                echo ' class="admin"';
            }
            else{
                echo ' class="not-admin"';
            }
        }
        else{
            echo ' class="not-logged-in"';
        }
    ?>
    >
    
    <header class="container-1024">
        
        <div class="col-xs-10 col-sm-6 logo-img">
            <div></div>            
        </div> 
        
        <?php if(!is_user_logged_in()){ //Utente non loggato ?>
        <div class="col-xs-12 col-sm-6 logo-txt">
            Il primo social network che ti connette al professionista più vicino a te
        </div> 
        <?php } else { //Utente loggato ?>
        <!-- menu utente loggato -->
        <div class="col-sm-6 hidden-xs menu">
            <img class="avatar-50" src="<?php echo $img ?>" alt="<?php $current_user->display_name ?>" />
            <div class="user-name">                
               <?php 
                    //stampo il nome dell'utente
                    if(strlen($current_user->display_name) > $max_lenght_nome){
                        echo substr($current_user->display_name, 0,$max_lenght_nome).'...'; 
                    }
                    else{
                        echo $current_user->display_name;
                    }
                        
                ?>             
            </div>
            
            <div class="icona posta" data-name="posta">
                <?php
                    if($n_posta > 0){
                        echo '<div class="notifica">'.$n_posta.'</div>';                        
                    }
                ?>
                <div class="triangolo"></div>
            </div>            
            <div class="icona notifiche" data-name="notifiche">
               <?php
                    if($n_notifiche > 0){
                        echo '<div class="notifica">'.$n_notifiche.'</div>';                       
                    }
                ?>  
                 <div class="triangolo"></div>
            </div>
            <div class="icona collaborazioni" data-name="collaborazioni">
               <?php
                    if($n_collab > 0){
                        echo '<div class="notifica">'.$n_collab.'</div>';
                    }
                ?>   
                 <div class="triangolo"></div>
            </div>
            <div class="icona cv" data-name="cv">
                 <div class="triangolo"></div>
            </div>
            <div class="icona impostazioni" data-name="impostazioni">
                 <div class="triangolo"></div>
            </div>
           
        </div>
        <div class="submenus hidden-xs col-sm-5">
            <!-- SOTTO MENU PER LA POSTA -->
            <div class="sub-menu" data-name="posta">
                <a href="<?php echo bp_loggedin_user_domain() ?>messages">                   
                    Posta in arrivo
                    <?php
                        if($n_posta > 0){
                            echo '<div class="notifica">'.$n_posta.'</div>';                        
                        }
                    ?>
                </a>
                <a href="<?php echo bp_loggedin_user_domain() ?>messages/sentbox"> Inviati</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>messages/compose"> Scrivici</a>
            </div>
            <!-- SOTTO MENU PER LE NOTIFICHE -->
            <div class="sub-menu" data-name="notifiche">
                <?php
                    //ottengo le notifiche
                    $notifiche = bp_notifications_get_notifications_for_user( $current_user->ID, 'string' );
                    if(count($notifiche) > 10){
                        //Se ci sono più di 10 notifiche all'11-esima visualizzo il link per vederle tutte
                        $count = 0;
                        foreach($notifiche as $notifica){
                            if($count < 10){
                                echo $notifica;
                            }
                            else{
                                break;
                            }
                            $count++;
                        }
                        echo '<a href="'.bp_loggedin_user_domain().'notifications">vedi tutte le notifiche</a>';
                    }
                    else{
                        foreach($notifiche as $notifica){
                            echo $notifica;                            
                        }
                    }
                
                ?>
            </div>
            <!-- SOTTOMENU PER LE COLLABORAZIONI -->
            <div class="sub-menu" data-name="collaborazioni">
                <a href="<?php echo bp_loggedin_user_domain() ?>friends" >Collaborazioni</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>friends/requests">
                    Richieste in sospeso
                    <?php
                        if($n_collab > 0){
                            echo '<div class="notifica">'.$n_collab.'</div>';                        
                        }
                    ?>
                </a>
            </div>
            <!-- SOTTOMENU PER I CV -->
            <div class="sub-menu" data-name="cv">
                <a href="<?php echo home_url() ?>/scopri-cv">Scopri i curriculum</a>
            </div>
            <!-- SOTTOMENU PER LE IMPOSTAZIONI -->
            <div class="sub-menu" data-name="impostazioni">
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/edit">Modifica profilo</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/public">Visualizza profilo</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/change-avatar">Cambia immagine profilo</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>settings">Impostazioni</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>settings/notifications">Notifiche</a>
                <a href="<?php echo wp_logout_url() ?>">Logout</a>
            </div>
        </div>
        
        <!-- fine menu utente loggato -->
        <div class="col-xs-2 hambuger-menu visible-xs">
            <div></div>
        </div>
        
        <!-- menu mobile -->
        <div class="col-xs-8 mobile-menu">
            <div class="col-xs-12" style="padding-bottom:10px;">
                <div class="chiudi"></div>
                <!-- UTENTE -->
                <div class="utente riga">
                    <img class="avatar-50" src="<?php echo $img ?>" alt="<?php $current_user->display_name ?>" />
                    <div class="title">
                        <?php 
                            //stampo il nome dell'utente
                            if(strlen($current_user->display_name) > $max_lenght_nome){
                                echo substr($current_user->display_name, 0,$max_lenght_nome).'...'; 
                            }
                            else{
                                echo $current_user->display_name;
                            }

                        ?>                        
                    </div>
                </div>
                
                <!-- POSTA -->
                <div class="posta riga">
                    <div class="icona">
                        <?php
                            if($n_posta > 0){
                                echo '<div class="notifica">'.$n_posta.'</div>';                        
                            }
                        ?>
                    </div>
                    <div class="title">Posta</div>
                    <div class="sotto-menu">
                        <a href="<?php echo bp_loggedin_user_domain() ?>messages">                   
                            - Posta in arrivo
                            <?php
                                if($n_posta > 0){
                                    echo '<div class="notifica">'.$n_posta.'</div>';                        
                                }
                            ?>
                        </a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>messages/sentbox">- Inviati</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>messages/compose">- Scrivici</a>
                    </div>                    
                </div>
                <!-- NOTIFICHE -->
                <div class="notifiche riga">
                    <a href="<?php echo bp_loggedin_user_domain() ?>notifications" class="icona">
                        <?php
                            if($n_notifiche > 0){
                                echo '<div class="notifica">'.$n_notifiche.'</div>';                       
                            }
                        ?>  
                    </a>
                    <div class="title">
                        <a href="<?php echo bp_loggedin_user_domain() ?>notifications">Notifiche</a>
                    </div>
                </div>
                <!-- COLLABORAZIONI-->
                <div class="collaborazioni riga">
                    <div class="icona">
                        <?php
                            if($n_collab > 0){
                                echo '<div class="notifica">'.$n_collab.'</div>';
                            }
                        ?>   
                    </div>
                    <div class="title">Collaborazioni</div>
                    <div class="sotto-menu">
                        <a href="<?php echo bp_loggedin_user_domain() ?>friends" >- Collaborazioni</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>friends/requests">
                            - Richieste in sospeso
                            <?php
                                if($n_collab > 0){
                                    echo '<div class="notifica">'.$n_collab.'</div>';                        
                                }
                            ?>
                        </a>
                    </div>         
                </div>
                <!-- CURRICULUM -->
                <div class="cv riga">
                    <a href="<?php echo home_url() ?>/scopri-cv" class="icona"></a>
                    <div class="title">
                        <a href="<?php echo home_url() ?>/scopri-cv">Curriculum</a>
                    </div>
                </div>
                <!-- IMPOSTAZIONI -->
                <div class="impostazioni riga">
                    <div class="icona"></div>
                    <div class="title">Impostazioni</div>
                    <div class="sotto-menu">
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/edit">- Modifica profilo</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/public">- Visualizza profilo</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/change-avatar">- Cambia immagine</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>settings">- Impostazioni</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>settings/notifications">- Notifiche</a>
                        <a href="<?php echo wp_logout_url() ?>">- Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- end menu mobile -->
        
        
        <?php } ?>
    
    </header>
