<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Help Page
 */

get_header();


//$image = get_the_post_thumbnail(get_the_ID(), 'full');
$url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

?>

<div class="main-container help-page" style="background:url('<?php echo $url ?>') center center">
    
    <div class="container-1024">
        
        <h1 class="col-xs-12 
         <?php
            if(strtolower(get_the_title()) == 'aiutaci a migliorare'){
                echo ' migliorare';
            }
            else if(strtolower(get_the_title()) == 'assistenza'){
                echo ' assistenza';
            }
         ?>
            ">
            <?php echo get_the_title(); ?> 
        </h1>
        <div class="clear"></div>
    </div>        
       
    
    <div class="main-content">
        <div class="container-1024">
            <div class="col-xs-12">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>		
                        <?php the_content(); ?>  
                    <?php endwhile; ?>

                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>


<?php get_footer(); ?>