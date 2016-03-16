<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Registrazione
 */

get_header();

?>

<div class="main-container registrazione">
    <div class="first-main-container">
        <div class="container-1024">
            <h1 class="col-xs-12">
                The WorkNote CV<br>richiedere lavoro
            </h1>
            <div class="clear"></div>
        </div>        
    </div>
    
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>		
            <?php the_content(); ?>  
        <?php endwhile; ?>

    <?php endif; ?>
</div>


<?php get_footer(); ?>