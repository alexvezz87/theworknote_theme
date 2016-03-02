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
    <div class="container-header">
        <header class="container-1024">

            <div class="col-xs-10 col-sm-6 logo-img">
                <div></div>            
            </div> 

            <?php if(!is_user_logged_in()){ //Utente non loggato ?>
            <div class="col-xs-12 col-sm-6 logo-txt">
                Il primo social network che ti connette al professionista più vicino a te
            </div> 
            <?php } else { //Utente loggato 

                //aggiungo il menu personalizzato dalle grafiche
                echo add_menu_personalizzato($current_user);

            } ?>
            <div class="clear"></div>
        </header>
    </div>
