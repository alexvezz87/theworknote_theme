<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Home
 */

get_header();

?>

<div class="main-container home">
   
    <div class="container-1024">
        
        <div class="col-xs-12 visible-xs no-padding ricerca-mobile">
            <?php add_motore_ricerca() ?>
        </div>
        <div class="main-content col-xs-12 col-sm-8 no-padding">

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>		
                    <?php the_content(); ?>  
                <?php endwhile; ?>

            <?php endif; ?>
            <div class="clear"></div>
        </div>

        <div class="sidebar col-xs-12 col-sm-4 hidden-xs">
            <?php add_motore_ricerca() ?>
             
            <div class="pre-main">    
                <div class="icona-news"></div>
                <div class="feed-news">
                    <?php if (function_exists (rss_scr_show)) rss_scr_show(); ?>                   
                </div>
            </div>
            <div class="clear"></div>
            <div class="right-sidebar">
                <?php dynamic_sidebar('right_bar_1'); ?>                                
            </div>
            
            
        </div>
        <div class="clear"></div>
    </div>
</div>


<?php get_footer(); ?>