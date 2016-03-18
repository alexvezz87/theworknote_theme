<?php

/**
 * The Work Note functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage theworknote_theme
 * @since The Work Note 1.0
 */

require_once 'myWidget.php';
include( ABSPATH.'wp-content/plugins/buddypress/bp-templates/bp-legacy/buddypress-functions.php' );

/**
 * The Work Note only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}



if ( ! function_exists( 'twn_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twn_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	//load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'theworknote' ),
		//'social'  => __( 'Social Links Menu', 'bed_and_art' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );
        
        

	//$color_scheme  = twentyfifteen_get_color_scheme();
	//$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
//	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
//		'default-color'      => $default_color,
//		'default-attachment' => 'fixed',
//	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	//add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twn_setup' );

add_theme_support( 'buddypress' );


//ADD WIDGET
function myplugin_register_widgets() {
	register_widget( 'MyWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );

//ADD SIDEBAR
function add_personal_sidebar() {
    register_sidebar( array(
        'name' => __( 'MySidebar', 'theworknote_theme' ),
        'id' => 'personal_sidebar_1',
        'description' => __( 'Questa sidebar è personalizzata per me.', 'DailyNews' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'add_personal_sidebar' );

//ADD SIDEBAR
function add_header_bar() {
    register_sidebar( array(
        'name' => __( 'HeaderBar', 'theworknote_theme' ),
        'id' => 'header_bar_1',
        'description' => __( 'SideBar che compare nell\'header', 'make-child' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'add_header_bar' );

//ADD SIDEBAR
function add_right_bar() {
    register_sidebar( array(
        'name' => __( 'Right sidebar', 'theworknote_theme' ),
        'id' => 'right_bar_1',
        'description' => __( 'SideBar che a destra', 'theworknote_theme' ),
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'add_right_bar' );


/**
 * Aggiunge il menu personalizzato 
 * @param type $current_user
 */
function add_menu_personalizzato($current_user){
    
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
    
    include 'menu.php';
}


/**
 * Aggiunge il motore di ricerca alla pagina che invoca la funzione
 */
function add_motore_ricerca(){
    include 'motore-ricerca.php';
}

add_action('wp_logout','go_home');
add_action('wp_login','go_home');
function go_home(){
  wp_redirect( home_url() );
  exit();
}



//Serie di funzioni per ottenere dati che modificheranno il flusso del loop-activty

//Funzione che mi restituisce l'immagine aziendale
function getImmagineAziendale(){
    global $wbdb;
    
    //preparo la query
    $query_get_fields_description = "SELECT fields.name as name, data.value as value
                                                FROM `wp_bp_xprofile_data` data
                                                JOIN `wp_bp_xprofile_fields` fields on fields.id = data.field_id
                                                JOIN `wp_bp_xprofile_groups` groups on groups.id = fields.group_id
                                                WHERE groups.id = 1
                                                AND data.user_id = $id_user";
    $result_fields_description = $wpdb->get_results($query_get_fields_description);
    
    
}

function curPageURL() {
    $pageURL = 'http';
    //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * Funzione che restituisce l'ID del campo Categoria Commerciale (nome impostato di default) * 
 * @return type
 */
function getCategoriaCommercialeID($wpdb){    
    $table_name = 'wp_bp_xprofile_fields';
    $name = 'Categoria commerciale';   
    $query = "SELECT id FROM $table_name WHERE $table_name.name='$name'";    
    return $wpdb->get_var($query);
}


/**
 * La funzione restituisce l'ID del campo famiglia 'Provincia' nella tabella di buddypress
 * @param type $wpdb
 * @return type
 */
function getProvinciaID($wpdb){
    $table_name = 'wp_bp_xprofile_fields';
    $name = 'Provincia';   
    $query = "SELECT id FROM $table_name WHERE $table_name.name='$name'";    
    return $wpdb->get_var($query);
}

/**
 * Funzione che restituisce la lista delle option dedicate a Categoria Commerciale
 * 
 * @global type $wpdb
 * @return type
 */
function getValueCategoriaCommerciale(){
    global $wpdb;
    $table_name = 'wp_bp_xprofile_fields';
    
    $categoryID = getCategoriaCommercialeID($wpdb);
    if($categoryID != NULL){
        $query = "SELECT name, id FROM $table_name WHERE parent_id = $categoryID ORDER BY name ASC";
        return $wpdb->get_results($query);
    }
    else{
        return NULL; 
    }
}

function printSelectCategoriaCommerciale($categoria_select){
    
    $categorie = getValueCategoriaCommerciale();
    
    if(count($categorie) > 0){    
        echo '<select id="select-categoria" name="categoria">';
        echo '<option value="tutte">Tutte</option>';
        for($i=0; $i < count($categorie); $i++){
            if($categoria_select == $categorie[$i]->name ){
                echo '<option value="'.$categorie[$i]->name.'" selected>'.$categorie[$i]->name.'</option>';
            }
            else{
                echo '<option value="'.$categorie[$i]->name.'">'.$categorie[$i]->name.'</option>';
            }
        }
        
        echo'</select>';
    }
}

function getSelectCategoriaCommerciale(){
    
    $categorie = getValueCategoriaCommerciale();
    $html = "";
    
    
    if(count($categorie) > 0){       
        $html.= '<select class="categoria-commerciale" name="categoria" required>';
       
        for($i=0; $i < count($categorie); $i++){          
            $html.= '<option value="'.$categorie[$i]->id.'">'.$categorie[$i]->name.'</option>';            
        }
        
        $html.= '</select>';
    }
    
    return $html;
    
}

/**
 * Variante del selectCategoriaCommerciale ma non è obbligatorio selezionarla
 * Usato per la ricerca
 * @return string
 */
function getSelectCategoriaCommercialeNotRequired(){
    $categorie = getValueCategoriaCommerciale();
    $html = "";
    
    
    if(count($categorie) > 0){       
        $html.= '<select class="categoria-commerciale" name="ricerca-categoria"><option value=""></option>';
        
        for($i=0; $i < count($categorie); $i++){
            if(isset($_POST['ricerca-categoria']) && $_POST['ricerca-categoria'] == $categorie[$i]->id ){
                $html.= '<option value="'.$categorie[$i]->id.'" selected>'.$categorie[$i]->name.'</option>';     
            }
            else{
                $html.= '<option value="'.$categorie[$i]->id.'">'.$categorie[$i]->name.'</option>';            
            }
        }
        
        $html.= '</select>';
    }
    
    return $html;
}

function getNomeCategoriaById($idCategoria){
    global $wpdb;
    $table_name = 'wp_bp_xprofile_fields';    
    $query = "SELECT name FROM $table_name WHERE id = $idCategoria";
    return $wpdb->get_var($query);
}

//Funzioni per l'utente corrente

/**
 * La funzione passato l'id di un utente, restituisce una stringa che indica il nome della categoria
 * Restituisce NULL in caso sopraggiungano errori
 * 
 * @global type $wpdb
 * @param type $userID
 * @return type
 */
function getValueCategoriaByUser($userID){
    global $wpdb;
    //ottengo l'id della categoria commerciale
    $categoryID = getCategoriaCommercialeID($wpdb);
    if($categoryID != NULL && $userID != NULL){
        //se ho dei valori proseguo
        //preparo la query per ottenere il nome della categoria
        $table = 'wp_bp_xprofile_data';
        $query = "SELECT value FROM $table WHERE field_id = $categoryID AND user_id = $userID";
        return $wpdb->get_var($query);        
    }
    else{
        return NULL;
    }
}

/**
 * La funzione passato l'id dell'utente restituisce l'id della categoria a lui associata
 * @global type $wpdb
 * @param type $userID
 * @return type
 */
function getIdCategoriaByUser($userID){
    global $wpdb;
    //ottengo l'ID della categoria commerciale
    $categoryID = getCategoriaCommercialeID($wpdb);
    if($categoryID != NULL && $userID != NULL){
        $table = 'wp_bp_xprofile_fields';
        //ottengo il value
        $value = getValueCategoriaByUser($userID);       
        //effettuo la query
        $query = "SELECT id FROM $table WHERE parent_id = $categoryID AND name = '".$value."'";       
        return $wpdb->get_var($query);
    }
    else{
        return NULL;
    }
}

function getValueProvinciaByUser($userID){
    global $wpdb;
    //ottengo l'ID della famiglia Provincia
    $provinciaID = getProvinciaID($wpdb);
    if($provinciaID != NULL && $userID != NULL){
       $table = 'wp_bp_xprofile_data'; 
       $query = "SELECT value FROM  $table  WHERE user_id = $userID AND field_id = $provinciaID";        
       return $wpdb->get_var($query);
    }
    else{
        return NULL;
    }
}

/**
 * La funzione preso in ingresso il nome della categoria, 
 * restituisce un array contenente gli ID degli utenti che appartengono a quella determinata categoria
 * In caso di errori restituisce NULL
 * 
 * @global type $wpdb
 * @param type $nomeCategoria
 * @return type
 */
function getUserIdsByCategoryName($nomeCategoria){
    global $wpdb; 
    if($nomeCategoria != NULL){
        $table = 'wp_bp_xprofile_data';
        $query = "SELECT user_id FROM $table WHERE value = '$nomeCategoria'";
        try{
            $temp = $wpdb->get_results($query);
            $result = array();
            for($i=0; $i < count($temp); $i++ ){
                $result[$i] = $temp[$i]->user_id;
            }
            
            return $result;
        }
        catch(Exception $ex){
            return NULL;
        }
    }
    else{
        return NULL;
    }
}

/**
 * Dato in ingresso un url di members, viene restituito uno username
 * 
 * @param type $url
 * @return type
 */
function getUsername($url){
     //controllo in che pagina sono
    $split_url = explode('/members/', $url);
    if(count($split_url) > 0){
        //se sono nella pagina di un utente splitto il nome dall'indirizzo        
        //ho ottenuto tutto il nome dopo la stringa ..../memebers/
        //ho ora da trovare il nome in nome_utente/*
        try{
            $temp_user_name = explode('/', $split_url[1]);
            $user_name = $temp_user_name[0];
            return $user_name;
        }
        catch(Exception $e){
            echo $e;
            return null;
        }
    }
}

/**
 * La funzione ricevuto in ingresso un url, controlla se si tratta di un pagina utente e filtra l'id dell'utente in questione
 * ricavandolo dallo user indicato nell'indirizzo url.
 * 
 * @param type $url
 * @return type
 */
function getIdMemeber($url){
   
    //controllo in che pagina sono
    $split_url = explode('/members/', $url);
    $user_name="";
    if(count($split_url) > 0){
        //se sono nella pagina di un utente splitto il nome dall'indirizzo        
        //ho ottenuto tutto il nome dopo la stringa ..../memebers/
        //ho ora da trovare il nome in nome_utente/*
        try{
            $temp_user_name = array();
            if(count($split_url) > 1){
                $temp_user_name = explode('/', $split_url[1]);
            }
            if(count($temp_user_name) > 0){
                $user_name = $temp_user_name[0];
            }
            //nasce la problematica che gli utenti che hanno il carattere spazio nello username,
            //questo viene sostituito da '-' nell'url.
            //Devo fare un controllo su questi attraverso un ciclo su tutti gli username degli utenti
            //e standardizzarli in maniera uguale
            
            global $wpdb;
            $query = "SELECT ID, user_login FROM wp_users";
            $temp = $wpdb->get_results($query);
            
            for($i=0; $i < count($temp); $i++){
               
                $temp2 = str_replace(' ', '-', $temp[$i]->user_login);
                $temp2 = str_replace('.', '-', $temp2);
                
                if(strtolower($user_name) == strtolower($temp2) ){
                    return $temp[$i]->ID;
                }
            }
            
            return null;
            
//            if(($wp_user = get_user_by( 'login', $user_name )) != false){
//                return $wp_user->ID;
//            }
//            else{
//                return null;
//            }            
        } catch (Exception $ex) {
            return null;
        }       
    }
    else{
        return null;
    }
    
}

/**
 * La funzione prende in ingresso lo userid corrente e l'url della pagina.
 * Controlla se l'utente corrente è associato al profilo e se viene soddisfatta
 * questa condizione, stampa a video un bottone che re-indirizza alla pagina di
 * modifica delle foto della galleria
 * @param type $userID
 * @param type $url
 */
function printModifyImagesButton($userID, $url){
    //ottengo l'id utente dall'url passato
    $userID_url = getIdMemeber($url);
    if($userID == $userID_url){
        $user_info = get_userdata($userID);
        $url = get_home_url().'/members/'.$user_info->user_login.'/profile/edit/group/3/';
        echo '<a class="btn gallery" href="'.$url.'">Modifica Galleria</a>';
    }
}

function printModifyOrariApertura($userID, $url){
    //ottengo l'id utente dall'url passato
    $userID_url = getIdMemeber($url);
    if($userID == $userID_url){
        $user_info = get_userdata($userID);
        $url = get_home_url().'/members/'.$user_info->user_login.'/profile/edit/group/4/';
        echo '<a class="btn gallery" href="'.$url.'">Modifica orari</a>';
    }
}

function printProfileUserButton($url){                  
    echo '<a class="btn gallery" href="'.get_home_url().'/members/'.getUsername($url).'/profile">Profilo</a>';
}

function getEmailUser($url){
    $username = getUsername($url);
    $user = get_user_by('login', $username);
    return $user->user_email;
}

/**
 * La funzione restituisce tutti gli id degli utenti
 * @global type $wpdb
 * @return type
 */
function getAllIdsUser(){
    global $wpdb;
    $query = "SELECT ID FROM wp_users";
    $temp =  $wpdb->get_results($query);
    $result = array();
    for($i=0; $i < count($temp); $i++){
        $result[$i] = $temp[$i]->ID;
    }    
    return $result;    
}


function getField($id, $nameField){
    global $wpdb;
    
    try{
        //prendo il field_id del nome passato
        $query_1 = "SELECT id FROM wp_bp_xprofile_fields WHERE name = '$nameField'";
        $field_id = $wpdb->get_var($query_1);        
             
        //prendo il valore finale
        $query_result = "SELECT value FROM wp_bp_xprofile_data WHERE field_id = $field_id AND user_id = $id";
        //echo $query_result;
       
        return $wpdb->get_var($query_result);
        
    }
    catch(Exception $ex){
        return '';
    }
}

function getRagioneSociale($id){
    global $wpdb;
    
    try{
        //prendo il field_id della ragione sociale
        $query_1 = "SELECT id FROM wp_bp_xprofile_fields WHERE name = 'Ragione Sociale'";
        $field_id = $wpdb->get_var($query_1);        
             
        //prendo il valore finale
        $query_result = "SELECT value FROM wp_bp_xprofile_data WHERE field_id = $field_id AND user_id = $id";
        //echo $query_result;
        return $wpdb->get_var($query_result);
        
    }
    catch(Exception $ex){
        return null;
    }
}

function getMotto($id){
    global $wpdb;
    
    try{
        //prendo il field_id della ragione sociale
        $query_1 = "SELECT id FROM wp_bp_xprofile_fields WHERE name = 'Motto'";
        $field_id = $wpdb->get_var($query_1);        
             
        //prendo il valore finale
        $query_result = "SELECT value FROM wp_bp_xprofile_data WHERE field_id = $field_id AND user_id = $id";
        //echo $query_result;
        return $wpdb->get_var($query_result);
        
    }
    catch(Exception $ex){
        return null;
    }
}

function getDescriptionFields($id_user){
    global $wpdb;
    //preparo la query
    $query_get_fields_description = "SELECT fields.name as name, data.value as value
                                    FROM `wp_bp_xprofile_data` data
                                    JOIN `wp_bp_xprofile_fields` fields on fields.id = data.field_id
                                    JOIN `wp_bp_xprofile_groups` groups on groups.id = fields.group_id
                                    WHERE groups.id = 1
                                    AND data.user_id = $id_user 
                                    ORDER BY field_order";
    return $wpdb->get_results($query_get_fields_description);
}

function getGallery($id_user){
    global $wpdb;
    $query_get_images = "SELECT fields.name as name, data.value as value
                                               FROM `wp_bp_xprofile_data` data
                                                JOIN `wp_bp_xprofile_fields` fields on fields.id = data.field_id
                                                JOIN `wp_bp_xprofile_groups` groups on groups.id = fields.group_id
                                                WHERE groups.id = 3
                                                AND data.user_id = $id_user";
    return $wpdb->get_results($query_get_images);
}

function getAddress($id_user){
    global $wpdb;
     $query_get_address = "SELECT fields.name as name, data.value as value
                                                FROM `wp_bp_xprofile_data` data
                                                JOIN `wp_bp_xprofile_fields` fields on fields.id = data.field_id
                                                JOIN `wp_bp_xprofile_groups` groups on groups.id = fields.group_id
                                                WHERE groups.id = 2
                                                AND data.user_id = $id_user";
    return  $wpdb->get_results($query_get_address);
}


//RITORNA IL NUMERO DI LIKE DI UN POST
function my_show_favorite_count($id) {

    return  bp_activity_get_meta($id, 'favorite_count' );
}

add_action( 'bp_activity_entry_meta', 'my_show_favorite_count' );


/**TEST AJAX **/
add_action( 'wp_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {           
            //contatore di like
            $('.button.fav, .button.unfav').click(function(){
               
                var idActivity = $(this).parent().find('input[name=activity-id]').val();                
                var data = {
			'action': 'my_action',
			'activityID': idActivity
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
                    $('li#activity-'+idActivity+' .likes-number').text(response);			
		});
            });
            
            //se faccio tap da mobile
            $('.button.fav, .button.unfav').on('tap', function(){
               
                var idActivity = $(this).parent().find('input[name=activity-id]').val();                
                var data = {
			'action': 'my_action',
			'activityID': idActivity
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
                    $('li#activity-'+idActivity+' .likes-number').text(response);			
		});
            });
            
	});
	</script> <?php
}

add_action( 'wp_ajax_my_action', 'my_action_callback' );

function my_action_callback() {
	

	$activityID = intval( $_POST['activityID'] );
        sleep(1);
        if(bp_activity_get_meta($activityID, 'favorite_count' ) != 0){
            echo bp_activity_get_meta($activityID, 'favorite_count' );
        }
        else{
            echo '';
        }

	wp_die(); // this is required to terminate immediately and return a proper response
}


function updateBuddypressProvincia($idUtente, $provincia){
    //per ottenere il valore da aggiornare devo conoscere oltre ai due parametri passati, anche l'id della famiglia di provincia
    try{
        global $wpdb;
        $idProvincia = getProvinciaID($wpdb);
        //parte la query
        $tabella = 'wp_bp_xprofile_data';

        $wpdb->update( 
            $tabella, 
            array( 
                    'value' => $provincia,	// stringa		
            ), 
            array( 'field_id' => $idProvincia, 'user_id' => $idUtente ), 
            array( '%s'), 
            array( '%d', '%d' ) 
        );
        
        return true;
    } catch (Exception $ex) {
        _e($ex);
        return false;
    }    
            
}

function showCustomTime($time){
    //viene passata una data nella forma aaaa-mm-dd hh:mm:ss (es. 2015-09-13 16:30:40)
    //devo restituire gg/mm/aaaa hh:mm

    $temp = explode(' ', $time);
    $time1 = explode('-', $temp[0]);
    $time2 = explode(':', $temp[1]);
    
    $mese = '';
    //scrivo il mese
    switch ($time1[1]){
        case '01': $mese = 'gennaio'; break; 
        case '02': $mese = 'febbraio'; break; 
        case '03': $mese = 'marzo'; break; 
        case '04': $mese = 'aprile'; break; 
        case '05': $mese = 'maggio'; break; 
        case '06': $mese = 'giugno'; break; 
        case '07': $mese = 'luglio'; break; 
        case '08': $mese = 'agosto'; break; 
        case '09': $mese = 'settembre'; break; 
        case '10': $mese = 'ottobre'; break; 
        case '11': $mese = 'novembre'; break; 
        case '12': $mese = 'dicembre'; break; 
    }
    

    return '| '.$time1[2].' '.$mese.' '.$time1[0].' | ore '.$time2[0].':'.$time2[1];
}



/**
 * Resize xprofile image uploads before saving them to the filesystem
 */
function resize_image_uploads($data) {
    $field_id = $data->field_id;
    $field = new BP_XProfile_Field($field_id);

    
    for($i = 1; $i <= 4 ; $i++ ){
        if ($field->name === "Immagine 0".$i && !empty($data->value)) {
            $upload_dir = wp_upload_dir();
            $image_path = $upload_dir['basedir'] . $data->value;
            $image = new Imagick(realpath($image_path));

            if ($image->valid()) {

                $image->resizeImage(400, 210, Imagick::FILTER_LANCZOS, 1);
                $image->writeImage();
                $image->destroy();
            }
        }
    }
}

add_action('xprofile_data_before_save', __NAMESPACE__ . '\\resize_image_uploads', 15);

?>