<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Non registrato New
 */

get_header();
$path_img = esc_url( get_template_directory_uri() ).'/images/';
$id = get_the_ID();

$video = getUrlEmbedVideo( get_post_meta($id, 'video', true));
$bgCarusel = wp_get_attachment_url( get_post_thumbnail_id($id)); 
    
 
?>

<div class="main-container non-registrato new">
    <div class="first-main-container">
        <div class="container-1024">
        
            <div class="container-search-login">
                <?php
                    //aggiungo il motore di ricerca
                    echo add_motore_ricerca() 
                ?>
                <div class="container-login box-login-2">
                    <?php the_widget( 'BP_Core_Login_Widget' ); ?> 
                </div>
            </div>
            <div class="clear"></div>
        </div>    
        <div class="clear"></div>
    </div>
    
    <div class="white-main-container">
        <div class="container-1024">
            <h2>PERCHE' ISCRIVERSI E UTILIZZATE THEWORKNOTE?</h2>
            <ul class="twn-options">
                <li class="option1 col-xs-12 col-sm-4">
                    <p>
                        Ricercare e farsi trovare senza passare ore su internet
                        o al telefono con la famosa frase: "Conosci qualcuno che...?"
                    </p>
                </li>
                <li class="option2 col-xs-12 col-sm-4">
                    <p>
                        Una vetrina dove poter mostrare il proprio lavoro
                        e allo stesso tempo farsi pubblicità GRATIS!
                    </p>
                </li>
                <li class="option3 col-xs-12 col-sm-4"> 
                    <p>
                        Essere affiliati automaticamente a nuovi possibili CLIENTI!
                    </p>
                </li>
                <li class="clear"></li>
            </ul>
            <div class="click-prezzo col-xs-12">
                <p class="text-big">
                    Ultimo ma non ultimo il PREZZO!<br>
                    TheWorkNote ti offre questo e altri servizi ad un prezzo annuo IRRISORIO!
                </p>
                <a href="<?php echo home_url() ?>/prezzi">
                    SCOPRILO QUI
                </a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="gray-main-container">
        <div class="container-1024">
            <div class="col-xs-12 col-sm-6 title-h2">
                <h2>
                    <a href="<?php echo home_url() ?>/chi-siamo">
                        SCOPRI L'IDEA<br>DI THEWORKNOTE
                    </a>
                </h2>
            </div>
            <div class="col-xs-12 col-sm-6 image-h2">
                <a href="<?php echo home_url() ?>/chi-siamo">
                    <img src="<?php echo $path_img ?>home-icona04.png" />
                </a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="recensioni-container" style="background:url('<?php echo $bgCarusel ?>')">
        <div class="fascia-verde">
            <div class="container-1024">
                <h3>ALCUNE RECENSIONI DI ISCRITTI CHE HANNO INIZIATO A COLLABORARE</h3>
            </div>
        </div>
        
        <!-- CARUSEL -->
        <div class="container-carusel">
            <div class="container-1024">
                
                <div class="hidden-xs hidden-sm">
                    <?php printRecensioniCarusel() ?>
                </div>
                <div class="visible-sm">
                    <?php printRecensioniCarusel(2) ?>
                </div>
                <div class="visible-xs">
                    <?php printRecensioniCarusel(1) ?>
                </div>
                
            </div>
            <div class="clear" style="height: 1px"></div>
        </div>
        <!-- FINE CARUSEL-->
        
        <div class="container-1024">
            <a class="iscriviti-link" href="<?php echo home_url() ?>/registrazione/">ISCRIVITI SUBITO</a>
        </div>
        <div class="clear" style="height: 1px"></div>
    </div>
    
    <div class="second-main-container">
        <div class="container-1024">
            <div class="container-new-video col-xs-12 no-padding"> 
                <iframe src="<?php echo $video ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="clear" style="height: 1px"></div>
        </div>
        
        <div class="container-1024">
            <div class="col-xs-12 col-sm-5 link-box">
                <h2>Scopri i servizi di The Work Note</h2>
                <a class="button-link" href="<?php echo home_url() ?>/registrazione/">Iscriviti subito</a>
            </div>            
            <div class="logo-work-note col-sm-2 hidden-xs">
                <div></div>
            </div>
            <div class="col-xs-12 col-sm-5 link-box">
                <h2>Cerchi lavoro? Lascia il tuo curriculum</h2>
                <a class="button-link" href="<?php echo home_url() ?>/inserisci-cv/">Invia</a>
            </div>
        </div>
    </div>
    
    
    
    <!--
    <div class="second-main-container">
        <div class="container-1024">
            <div class="container-video col-sm-5 no-padding">        
                 <iframe width="100%" height="250" src="https://www.youtube.com/embed/f5Q9QyXpYJM?rel=0" frameborder="0" allowfullscreen></iframe>

            </div>


            <div class="container-contenuto col-sm-7 no-padding">
                <div class="col-xs-12">
                    <?php if ( have_posts() ) : ?>            

                            <?php
                            // Start the loop.
                            while ( have_posts() ) : the_post();
                                 the_content();


                            // End the loop.
                            endwhile;



                    // If no content, include the "No posts found" template.
                    else :
                            get_template_part( 'content', 'none' );

                    endif;
                    ?>
                    <div class="box-login hidden-xs">
                        <?php //the_widget( 'BP_Core_Login_Widget' ); ?> 
                    </div>
                </div>
                
                <div class="clear"></div>
            </div>
            
            
            <div class="col-xs-12 col-sm-5 link-box">
                <h2>Scopri i servizi di The Work Note</h2>
                <a class="button-link" href="<?php echo home_url() ?>/registrazione/">Iscriviti subito</a>
            </div>
            <div class="box-login visible-xs col-xs-12">
                <?php //the_widget( 'BP_Core_Login_Widget' ); ?> 
            </div>
            <div class="logo-work-note col-sm-2 hidden-xs">
                <div></div>
            </div>
            <div class="col-xs-12 col-sm-5 link-box">
                <h2>Cerchi lavoro? Lascia il tuo curriculum</h2>
                <a class="button-link" href="<?php echo home_url() ?>/inserisci-cv/">Invia</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
        <div class="clear"></div>
    </div>
</div>
-->    
    
<div class="clear"></div>


<?php get_footer(); ?>