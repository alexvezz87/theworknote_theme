<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Non registrato
 */

get_header();

?>

<div class="main-container">
    <div class="first-main-container">
        <div class="container-1024">
        
        
            <?php
                //aggiungo il motore di ricerca
                echo add_motore_ricerca() 
            ?>
             <div class="clear"></div>
        </div>    
        <div class="clear"></div>
    </div>
    <div class="second-main-container">
        <div class="container-1024">
            <div class="container-video col-sm-5 no-padding">        
                 <iframe width="100%" height="250" src="https://www.youtube.com/embed/f5Q9QyXpYJM" frameborder="0" allowfullscreen></iframe>

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
                        <?php the_widget( 'BP_Core_Login_Widget' ); ?> 
                    </div>
                </div>
                
                <div class="clear"></div>
            </div>
            
            
            <div class="col-xs-12 col-sm-5 link-box">
                <h2>Scopri i servizi di The Work Note</h2>
                <a class="button-link" href="<?php echo home_url() ?>/registrazione/">Iscriviti subito</a>
            </div>
            <div class="box-login visible-xs col-xs-12">
                <?php the_widget( 'BP_Core_Login_Widget' ); ?> 
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
<div class="clear"></div>


<?php get_footer(); ?>