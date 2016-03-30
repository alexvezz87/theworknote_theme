<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Invia CV
 */

get_header();

$type = 0;

$url = get_template_directory_uri ().'/images/desktop/';
$class = "";

if(strtolower(get_the_title())== 'scopri cv'){
    $type = 1; //Offrire lavoro 
    $url .= 'sfondo-scopri-cv.jpg';
    $class = 'scopri-cv';
}
else if(strtolower(get_the_title())== 'inserisci cv'){
    $type = 2; //Richiedere lavoro
    $url .= 'sfondo-invia-cv.jpg';
}

?>

<div class="main-container invia-cv <?php echo $class ?>">
    
    <div class="first-main-container visible-xs">
        <div class="container-1024">
            <h1 class="col-xs-12">
                <?php
                    if($type == 1){
                        echo 'The Work Note CV<br>offrire lavoro';
                    }
                    else if($type == 2){
                        echo 'The WorkNote CV<br>richiedere lavoro';
                    }
                ?>
                
            </h1>
            <div class="clear"></div>
        </div>        
    </div>
         
    
    <div class="first-main-container hidden-xs" style="background:url('<?php echo $url ?>')">
        <div class="container-1024">
            <h1 class="col-xs-12">
                <?php
                    if($type == 1){
                        echo 'The Work Note CV<br>offrire lavoro';
                    }
                    else if($type == 2){
                        echo 'The WorkNote CV<br>richiedere lavoro';
                    }
                ?>
                
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