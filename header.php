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

date_default_timezone_set('Europe/Rome');

//imposto alcuni path
$path_img = esc_url( get_template_directory_uri() ).'/images/';
$path_img_mobile = $path_img.'mobile/';
$path_js = esc_url( get_template_directory_uri() ).'/js/';
$path_css = esc_url( get_template_directory_uri() ).'/css/';

//ottengo il menu
$menu = wp_get_nav_menu_items( 'primary');

//current user
$current_user = wp_get_current_user();

$pagename = get_query_var('pagename');  
if ( !$pagename && $id > 0 ) {  
    // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object  
    $post = $wp_query->get_queried_object();  
    $pagename = $post->post_name;  
}

//redirect all'home page dell'attività se utente è loggato
if($pagename == 'non-registrato' && is_user_logged_in()){
    header("location: ".  home_url());
}


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
        
	
	<!--[if lt IE 9]>
	<script src="<?php echo $path_js ?>html5.js"></script>
	<![endif]-->
        
        
        <script src="<?php echo $path_js ?>jquery-2.1.4.min.js"></script>
        <!-- swiper -->
        <!--<link rel="stylesheet" href="<?php echo $path_css ?>swiper.min.css">  --> 
       
        <!-- end swiper -->  
        
        <script src="<?php echo $path_js ?>jquery-2.1.4.min.js"></script>
        <script src="<?php echo $path_js ?>jquery-ui.min.js"></script>
        <script src="<?php echo $path_js ?>jquery.mobile.custom.min.js"></script>
        <script src="<?php echo $path_js ?>bootstrap.min.js"></script>    
        <script src="<?php echo $path_js ?>functions.js"></script>
       
        
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" type="text/css" >
        
        
        
        <link rel="icon" href="<?php echo $path_img ?>favicon.png" type="image/png" />
        
        <script type="text/javascript">
            $(document).ready(function() {
                    $(".loader").fadeOut("slow");
            });
        </script>
        
        <?php wp_head(); ?>
        
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/style.css" type="text/css" >
	
        <!-- tag per facebook -->
        <?php 
            $id_user = getIdMemeber(curPageURL());
            $upload_dir = wp_upload_dir();
            
            $shareIMG = "";
            if($id_user != null){
                //immagine
                //prendo da immagine aziendale
                $shareIMG = getField(bp_displayed_user_id(), 'Immagine Aziendale');
                if($shareIMG == ''){
                    //se non c'è l'immagine aziendale, la prendo la prima immagine della galleria
                    $result_get_images = getGallery($id_user);
                    foreach($result_get_images as $k => $v){
                        $shareIMG = $v->value;
                        break;
                    } 
                }
                               
                //type
                echo '<meta property="og:type" content="website" />';
                
                //Titolo
                echo '<meta property="og:title" content="'.getField(bp_displayed_user_id(), 'Ragione Sociale').' | The WorkNote" />';  
                echo '<meta property="og:site_name" content="'.getField(bp_displayed_user_id(), 'Ragione Sociale').'" />';  
                
                //descrizione
                echo '<meta property="og:description" content="'.getField(bp_displayed_user_id(), 'Descrizione').'" />';                
                
                //url
                echo '<meta property="og:url" content="'.  curPageURL().'" />';
                
                 echo '<meta property="og:image" content="'.$upload_dir['baseurl'].$shareIMG.'" />';
            }
            
                
            
        
        ?>    
        <!-- fine tag per facebook -->
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
    <div class="loader"></div> 
    <div class="container-header">
        <header>
            <div class="container-1024">

                <div class="col-xs-10 col-sm-6 logo-img">
                    <a href="<?php echo home_url() ?>"></a>            
                </div> 

                <?php if(!is_user_logged_in()){ //Utente non loggato ?>
                <div class="col-xs-12 col-sm-6 logo-txt">
                    L'unico social network che semplifica il tuo lavoro
                </div> 
                <?php } else { //Utente loggato 

                    //aggiungo il menu personalizzato dalle grafiche
                    echo add_menu_personalizzato($current_user);

                } ?>
                <div class="clear"></div>
            </div>
        </header>
    </div>
