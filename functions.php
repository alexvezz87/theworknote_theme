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
require_once 'class/classes.php';
require_once 'widget_matching.php';

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
        register_widget( 'Matching' );
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


function getCategoriaByUser($userID){
    global $wpdb;
    //ottengo l'ID della categoria commerciale
    $categoryID = getCategoriaCommercialeID($wpdb);
    if($categoryID != NULL && $userID != NULL){
        $table = 'wp_bp_xprofile_fields';
        //ottengo il value
        $value = getValueCategoriaByUser($userID);       
        //effettuo la query
        $query = "SELECT name, id FROM $table WHERE parent_id = $categoryID AND name = '".$value."'";       
        //echo $query;
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


function getUserNameMember(){
    $url = curPageURL();
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
           
        } catch (Exception $ex) {
            return null;
        }       
    }
    
    return $user_name;
    
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

function isCurrentUserLoggedPage(){
    $userID_url = getIdMemeber(curPageURL());
    $current_user = wp_get_current_user();
    if($current_user->ID == $userID_url){
        return true;
    }
    return false;
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
       
        return stripslashes($wpdb->get_var($query_result));
        
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
                                                AND data.user_id = $id_user ORDER BY name ASC";
    
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

function showCustomTime2($time){
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
    

    return $time1[2].' '.$mese.' '.$time1[0].' | ore '.$time2[0].':'.$time2[1];
}




add_action( 'wp_ajax_my_ajax', 'my_ajax_callback' );
add_action( 'wp_ajax_nopriv_my_ajax', 'my_ajax_callback' );
function my_ajax_callback(){    
    //La chiamata ajax avviene per i commenti inseriti
    if(isset($_POST['commento'])){
        $result = false;
        $temp = $_POST['commento'];
        $c = new Commento();
        $c->setCommentText($temp['testo']);
        $c->setCommentLikes(0);
        $c->setIdCommentedUser($temp['idUserCommented']);
        $c->setIdCommentingUser($temp['idUserCommenting']);
        
        $controller = new CommentoController();
        //salvo il commento
        if($controller->saveComment($c) > 0){
            //commento andato a buon fine
            //ottengo gli altri commenti e li butto dentro
            $result = getCommenti($controller, $temp['idUserCommented']);            
        }
        
        
        echo json_encode($result);
        wp_die();
            
    }
    
    if(isset($_POST['idCommento']) && isset($_POST['idCommented'])){
        $result = false;
        
        $controller = new CommentoController();
        if($controller->deleteComment($_POST['idCommento'])){
           $result = getCommenti($controller, $_POST['idCommented']);   
        }
        
        echo json_encode($result);
        wp_die();
    }
}

add_action( 'wp_ajax_remove_proposto', 'removeUtenteProposto' );
add_action( 'wp_ajax_nopriv_remove_proposto', 'removeUtenteProposto' );

function removeUtenteProposto(){
    if(isset($_POST['idUtente']) && isset($_POST['idUtenteProposto'])){
        $result = false;
        $controller = new SottocategoriaController();
        
        if($controller->removeProposto($_POST['idUtente'], $_POST['idUtenteProposto'])){
            $result = true;
        }
        
        echo json_encode($result);
        wp_die();
        
    }
}

add_action( 'wp_ajax_log_email', 'logEmail' );
add_action( 'wp_ajax_nopriv_log_email', 'logEmail' );

/**
 * Funzione che gestisce il log e l'invio della mail messaggio dalla pagina utente
 */
function logEmail(){
    if(isset($_POST['idDest']) && isset($_POST['nomeMitt']) && isset($_POST['emailMitt']) && isset($_POST['oggetto']) && isset($_POST['messaggio'])){
        $destinatario = get_user_by('id', $_POST['idDest']); 
        $adminEmail = 'info@theworknote.com';
        
        //creo il log
        $log = new Log();
        $log->setDestinatario(getField( $_POST['idDest'], 'Ragione Sociale') );
        $log->setMittente($_POST['nomeMitt'].' ('.$_POST['emailMitt'].')');
        $log->setTipo('invio mail');
        
        //salvo il log
        $logController = new LogController();        
        $logController->saveLog($log);       
        
        //invio una mail al destinatario
        //aggiungo il filtro per l'html sulla mail
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
        $messaggio = '<img width="230" style="margin:auto" src="http://www.theworknote.com/wp-content/uploads/2016/09/theworknote_3D2.jpg" /><br><br>';
        $messaggio .= '<span>Qualcuno ti ha cercato...</span><br><br>';
        //$messaggio.= "<strong>Oggetto:</strong> ".$_POST['oggetto'].'<br>';
        $messaggio.= "<strong>da: </strong>".$_POST['nomeMitt'].'<br>';
        $messaggio.= '<strong>da mail: </strong> <a href="mailto:'.$_POST['emailMitt'].'">'.$_POST['emailMitt'].'</a><br>';
        $messaggio.= "<strong>Messaggio: </strong><br>";
        $messaggio.= stripslashes($_POST['messaggio']).'<br><br><br>';
        $messaggio.= "<hr><br>";
        $messaggio.= 'Servizio GRATUITO di <a href="http://www.theworknote.com">TheWorkNote</a><br><br>';
        $messaggio.= 'Ricordati di tenere aggiornato il profilo! <img width="50" src="http://www.theworknote.com/wp-content/uploads/2016/04/Good.jpg" />';
        
        $oggetto = "Servizio messaggi TWN: ".stripslashes($_POST['oggetto']);
        //array di email
        $to = array($destinatario->user_email);        
        if(wp_mail($to, $oggetto, $messaggio)){
            echo json_encode(true);
        }
        //invio una mail all'amministratore
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
        $oggetto = "Servizio messaggi TWN - Email inviata da ".$_POST['nomeMitt'].' a '.getField( $_POST['idDest'], 'Ragione Sociale');
        wp_mail($adminEmail, $oggetto, $messaggio);
        
        wp_die();
    }
}

add_action( 'wp_ajax_log_tel', 'logTelefono' );
add_action( 'wp_ajax_nopriv_log_tel', 'logTelefono' );

/**
 * Funzione che gestisce il logo visualizza telefono
 */
function logTelefono(){
    if(isset($_POST['idBPUser']) && isset($_POST['idWPUser'])){
        //creo il log
        $log = new Log();
        $log->setDestinatario(getField($_POST['idBPUser'], 'Ragione Sociale'));
        if($_POST['idWPUser'] == 0 ){
            $log->setMittente('Utente non registrato');
        }
        else{
            $log->setMittente(getField($_POST['idWPUser'], 'Ragione Sociale'));
        }
        $log->setTipo('visualizza telefono');
        
        //salvo il log
        $logController = new LogController();        
        $logController->saveLog($log); 
        
        
        //ottengo il numero di telefono        
        echo json_encode(getField($_POST['idBPUser'], 'Contatto telefonico'));  
        //attivo il cookie
        setcookie('scopriTelefono-'.$_POST['idBPUser'], true, time() + (86400 * 7), "/"); // 86400 = 1 day
        
        wp_die();
    }
}


function getCommenti($controller, $idCommented){
    //idCommented è l'id dell'utente della pagina in cui ci sono i commenti
    $array = $controller->getCommentsByAjax($idCommented);
    $result = array();
    foreach($array as $item){
        $item2 = array();
        $item2['ID'] = $item->ID;
        //sistemo il commenting user
        $user_info = get_userdata($item->id_commenting_user);                
        $item2['nome'] = $user_info->display_name;
        $item2['url'] = home_url().'/members/'.$user_info->user_login;
        $item2['time'] = showCustomTime2($item->comment_date);
        $item2['commento'] = $item->comment_text;
        $img = bp_core_fetch_avatar(  array( 'item_id' => $item->id_commenting_user, 'html' => false ) );
        $item2['avatar'] = '<img alt="'.$user_info->display_name.'" src="'.$img.'" />';
        $item2['idUserCommenting'] = $item->id_commenting_user;
        $item2['idUserCommented'] = $item->id_commented_user;
        array_push($result, $item2);
    }
    return $result;
}


//inserisco un menù di gestione degli utenti
function add_admin_theme_menu(){
    add_menu_page('Gestione Utenti', 'Gestione Utenti', 'administrator', 'gestione_utenti', 'add_gestione_utenti', get_bloginfo('template_directory').'/images/icona_20x28.png', 10 );
    add_submenu_page('gestione_utenti', 'Gestione Newsletter', 'Gestione Newsletter', 'administrator', 'gestione_newsletter', 'add_newsletter');
    add_submenu_page('gestione_utenti', 'Sottocategorie', 'Sottocategorie', 'administrator', 'gestione_sottocategorie', 'add_sottocategorie');
    add_submenu_page('gestione_utenti', 'Impostazioni', 'Impostazioni', 'administrator', 'impostazioni', 'add_impostazioni');
    add_submenu_page('gestione_utenti', 'Log', 'Log', 'administrator', 'log', 'add_log');
}


function add_gestione_utenti(){
    include 'admin-pages/gestione_utenti.php';
}

function add_impostazioni(){
    include 'admin-pages/impostazioni_utenti.php';
}

function add_newsletter(){
    include 'admin-pages/gestione_newsletter.php';
}

function add_sottocategorie(){
    include 'admin-pages/gestione_sottocategorie.php';
}


function add_log(){
    include 'admin-pages/visualizza_log.php';
}

//registro il menu
add_action('admin_menu', 'add_admin_theme_menu');



function calcolaScadenzaUtenti($users){
    //La funzione prende in pasto una lista di utenti e controlla se sono in regola
    //Il controllo si basa sul campo registrazione (data) e il calcolo dalla giornata odierna meno il periodo
    //quindi: data_iscrizione > oggi - periodo ==> utente scaduto
    
    $cImp = new ImpostazioneController();
    $cRinn = new RinnovoController();
    
    //ottengo i valori dei periodi dalle impostaizoni
    $periodoRinnovo = $cImp->getImpostazioneByNome('giorni-durata-rinnovo');
    $periodoProva = $cImp->getImpostazioneByNome('giorni-prova-gratuita');
    $periodoScadenza = $cImp->getImpostazioneByNome('giorni-preavviso-scadenza');
   
    //Il controllo diventa più complesso nel caso si debba vedere se un utente è stato rinnovato o meno
    //Il controllo prima parte per l'utente rinnovato
    //Se non è presente, si fa il controllo sul periodo di prova.
    
       
    //creo un array di risultati
    $result = array();
    //che si divide in utenti con iscrizione in corso
    $inCorso = array();
    //e utenti con iscrizione scaduta
    $scaduti = array();
    //e in scadenza
    $inScadenza = array();
    
    foreach($users as $u){
        $user = new WP_User();
        $user = $u;
        $utente = array();
        
        //individuo il periodo, che è deteriminato se un utente ha rinnovato o meno
        $periodo = $cRinn->isRinnovato($user->ID) ? $periodoRinnovo : $periodoProva;  
        //individuo la data a cui fare riferimento per contare i periodi
        $dataPartenza = $cRinn->isRinnovato($user->ID) ? $cRinn->getDataRinnovo($user->ID) : $user->user_registered;
        
        
        $utente['ID'] = $user->ID;
        $utente['nome'] = $user->user_firstname.' '.$user->user_lastname;
        $utente['email'] = $user->user_email;
        $utente['registrazione'] =  showCustomTime2($user->user_registered);
        $utente['rinnovo'] = "non ha ancora rinnovato";
        if($cRinn->isRinnovato($user->ID)){
            $utente['rinnovo'] = showCustomTime2($cRinn->getDataRinnovo($user->ID));
        }
        
        //calcolo il tempo              
        $oggi=time();
        //Giorni da sottrarre
        $giorni=$periodo*24*60*60;
        $datascadenza=strtotime($dataPartenza)+$giorni;
        
        $giorniScarto = datediff('G', date("d-m-Y",$datascadenza), date("d-m-Y",$oggi));
        $utente['time'] = $giorniScarto;
        
        if($datascadenza > $oggi){
            //in corso
            if($giorniScarto <= $periodoScadenza){
                //utenti in scadenza
                array_push($inScadenza, $utente);
            }
            else{
                array_push($inCorso, $utente);
            }
        }
        else{
            //scaduto
            array_push($scaduti, $utente);
        }

       
    }
    $result['scaduti'] = $scaduti;
    $result['inScadenza'] = $inScadenza;
    $result['inCorso'] = $inCorso;
    
    return $result;
}


function printTabelleUtenti($array){
    if(count($array) > 0){
    
        foreach ($array as $k => $v) {
            if($k == 'scaduti'){
                echo '<h3>Utenze scadute: '.count($v).'</h3>';  
                printTabellaUtenti($v, $k);
            }
            else if($k == 'inScadenza'){
                echo '<h3>Utenze in scadenza: '.count($v).'</h3>';
                printTabellaUtenti($v, $k);
            }
            else{
                echo '<h3>Utenze attive: '.count($v).'</h3>';
                //printTabellaUtenti($v, $k);
            }
            
        }
    }
    else{
        echo '<p>Non ci sono utenti da visualizzare</p>';
    }
}


function printTabellaUtenti($array, $tipo){

    
    $stringScadenza = " giorni alla scadenza";
    $blocca = "";
    $sblocca = "";
    
    if($tipo == 'scaduti'){
        $stringScadenza = " giorni passati dalla scadenza";  
        $blocca = '<input type="submit" name="blocca-utente" value="SOSPENDI UTENZA" />';
        $sblocca = '<input type="submit" name="sblocca-utente" value="RIATTIVA UTENZA" />';
    }    
    
    if(count($array) > 0){
?>
        <table class="table-cvs">
            <thead>
            <tr class="intestazione">
                <td>Utente</td>
                <td>Email</td>
                <td>Registrazione</td>
                <td>Rinnovo</td>
                <td>Scadenza</td>
                <td>Azione</td>
            </tr>
            </thead>
            <tbody>
<?php
            foreach($array as $item){
?>
            <tr>
                <td><?php echo $item['nome'] ?></td>
                <td><?php echo $item['email'] ?></td>
                <td><?php echo $item['registrazione'] ?></td>
                <td><?php echo $item['rinnovo'] ?></td>
                <td><?php echo $item['time'].$stringScadenza ?></td>
                <td>
                    <form action="<?php echo curPageURL() ?>" method="POST">
                        <input type="hidden" name="id-utente" value="<?php echo $item['ID'] ?>" />
                        <?php 
                            if(isUtenteBloccato($item['ID'])){
                                echo ' <input disabled type="submit" name="rinnova-utente" value="RINNOVA ORA" />';
                                echo $sblocca;
                            }
                            else{
                                echo ' <input type="submit" name="rinnova-utente" value="RINNOVA ORA" />';
                                echo $blocca;
                            }
                        ?>
                    </form>
                </td>
            </tr>
<?php
            }
?>           
            </tbody>
        </table>
<?php
    }
    else{
        echo '<p>Non ci sono utenti da visualizzare</p>';
    }
    
}


function datediff($tipo, $partenza, $fine)
{
    switch ($tipo)
    {
        case "A" : $tipo = 365;
        break;
        case "M" : $tipo = (365 / 12);
        break;
        case "S" : $tipo = (365 / 52);
        break;
        case "G" : $tipo = 1;
        break;
    }
    $arr_partenza = explode("-", $partenza);
    $partenza_gg = $arr_partenza[0];
    $partenza_mm = $arr_partenza[1];
    $partenza_aa = $arr_partenza[2];
    $arr_fine = explode("-", $fine);
    $fine_gg = $arr_fine[0];
    $fine_mm = $arr_fine[1];
    $fine_aa = $arr_fine[2];
    $date_diff = mktime(12, 0, 0, $fine_mm, $fine_gg, $fine_aa) - mktime(12, 0, 0, $partenza_mm, $partenza_gg, $partenza_aa);
    $date_diff  = floor(($date_diff / 60 / 60 / 24) / $tipo);
    return abs($date_diff);
}


function isUtenteBloccato($idUtente){
    try{
        global $wpdb;
        $query = "SELECT user_status FROM wp_users WHERE ID = ".$idUtente;

        $result = $wpdb->get_var($query);
        if($result == 0){
            return false;
        }
        return true;        
    } catch (Exception $ex) {
        _e($ex);
        return false;
    }
}

function updateUserStatus($idUtente, $status){
    global $wpdb;
    try{
        $wpdb->update(
                'wp_users',
                array('user_status' => $status),
                array('ID' => $idUtente),
                array('%d'),
                array('%d')
            ); 
        return true;
    } catch (Exception $ex) {
        _e($ex);
        return false;
    }
}


function getUpdatesUtente($parametri){
    //La funzione interroga la tabella wp_bp_activity ed estrapola i dati 
    global $wpdb;
    try{
        //ottengo tutte le attività tra aggiornamenti di stato e commenti
        $query = "SELECT a.user_id, count(a.user_id) as attivita, d.value as categoria "
                ."FROM wp_bp_activity a, wp_bp_xprofile_data d "
                ."WHERE component = 'activity' "
                ."AND date_recorded BETWEEN '".$parametri[0]."' AND '".$parametri[1]."' "
                ."AND d.user_id = a.user_id "
                ."AND d.field_id = 15 "
                ."GROUP BY user_id "
                ."ORDER BY categoria ASC, attivita DESC";
        //echo $query;
        
        $result = $wpdb->get_results($query);
        
        return $result;
    } catch (Exception $ex) {
        _e($ex);
        return false;
    }
    
}


function getEmailsFromCategoria($categoria){
    //La funzione data una categoria, restituisce un array di email di utenti appartenenti a quella categoria
    global $wpdb;
    try{
        $query = "SELECT user_id FROM wp_bp_xprofile_data WHERE value = '".$categoria."'";
        //echo $query;
        $idUtenti = $wpdb->get_results($query);
        
        $result = array();
        foreach($idUtenti as $id){            
            $user_info = get_userdata($id->user_id);
            array_push($result, $user_info->user_email);
        }
        
        return $result;
        
    } catch (Exception $ex) {
        _e($ex);
        return false;
    }
    
}


add_action( 'wp_ajax_my_ajax_get_emails', 'my_ajax_get_emails' );
add_action( 'wp_ajax_nopriv_my_ajax_get_emails', 'my_ajax_get_emails' );
function my_ajax_get_emails(){    
    if(isset($_POST['categoria'])){
        //ottengo le mail dalle catogorie
        $emails = getEmailsFromCategoria($_POST['categoria']);
        
        echo json_encode($emails);
        wp_die();        
    }
    
}

add_action( 'admin_enqueue_scripts', 'register_theme_admin_style' );
function register_theme_admin_style() {
    wp_register_style('admin-style', get_bloginfo('template_directory').'/css/style_admin_pages.css' );
    wp_enqueue_style('admin-style');
}



//Aggiungo il file di Javascript al tema
function register_twn_admin_js_script(){
    wp_register_script('jquery-ui', get_bloginfo('template_directory').'/js/jquery-ui.min.js', array('jquery'), '1.0', false);   
    wp_enqueue_script('jquery-ui');   
}

add_action( 'admin_enqueue_scripts', 'register_twn_admin_js_script' );

function printRemarketingGoogle($nomeUtente, $categoria){
    
?>
     
    <!-- Google Code per il tag di remarketing -->
    <!--------------------------------------------------
    I tag di remarketing possono non essere associati a informazioni di identificazione personale o inseriti in pagine relative a categorie sensibili. Ulteriori informazioni e istruzioni su come impostare il tag sono disponibili alla pagina: http://google.com/ads/remarketingsetup
    --------------------------------------------------->
    <script type="text/javascript">
        var google_tag_params = {
        dynx_itemid: "<?php echo $nomeUtente ?>",
        dynx_itemid2: "<?php echo $categoria ?>",
        dynx_pagetype: "Members",
        dynx_totalvalue: 30
        };
    </script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 944518337;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/944518337/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
        
<?php        
    
}


function printRecensioniCarusel($mode = 3){
    
    
    //ottengo le recensioni
    $args = array(
	'posts_per_page'   => -1,
	'offset'           => 0,	
	'category_name'    => 'recensioni',
	'orderby'          => 'date',
	'order'            => 'DESC',	
	'post_type'        => 'post',	
	'post_status'      => 'publish',
	'suppress_filters' => true 
    );
    $recensioni = get_posts( $args ); 
    
    //print_r($recensioni);
    
    $tot = count($recensioni);
    //misure di un singolo match (widht + margin-right)
    $singleElement = 235+60;
    //calcolo lunghezza ul
    $ulWidth = $tot * $singleElement;
    
    $ulContainerWidht = $mode * $singleElement;
    
    $widthCarusel =  ($ulContainerWidht + 60).'px';
    
?>
    <input type="hidden" name="liWidth" value="<?php echo $singleElement ?>" />
    <input type="hidden" name="ulWidth" value="<?php echo $ulContainerWidht ?>" />
    <div class="carusel" style="width:<?php echo $widthCarusel ?>">       
        <div class="arrow avanti"></div>
            <div class="container-ul" style="width:<?php echo $ulContainerWidht ?>px">
                <ul class="recensioni matching" style="width:<?php echo $ulWidth ?>px">
                <?php
                    foreach($recensioni as $item){
                        $categoria = get_post_meta($item->ID, 'categoria', true);
                        $logo =  wp_get_attachment_url( get_post_thumbnail_id($item->ID)); 
                        $titolo = $item->post_title;
                        if(strlen($item->post_title) > 22){
                            $titolo = substr($titolo, 0, 22).'...';
                        }
                        $url = get_post_meta($item->ID, 'url', true);
                         
                ?>
                    <li class="recensione">
                        <a href="<?php echo $url ?>" class="avatar" style="background:url('<?php echo $logo ?>')"></a>
                        <div class="container-utente">
                            <h4 class="nome-utente"><a href="<?php echo $url ?>"><?php echo $titolo ?></a></h4>
                            <div class="white-balloon">
                                <div class="categoria"><?php echo $categoria ?></div>
                                <p class="description">
                                    <?php echo $item->post_content ?>
                                </p>
                            </div>
                            <div class="triangolino"></div>
                        </div>
                    </li>
                <?php
                    }
                ?>
                </ul>
            </div>
        <div class="arrow indietro"></div>
    </div>
<?php    
    
}


function getUrlEmbedVideo($url){
    $embed_video = explode('watch?v=', $url);
    $idVideo = $embed_video[count($embed_video)-1]; 
    return 'https://www.youtube.com/embed/'.$idVideo.'?rel=0';
}

?>