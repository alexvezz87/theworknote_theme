<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Page Pagamento
 */

get_header();

$path_img = esc_url( get_template_directory_uri() ).'/images/';

?>


<div class="main-container page-pagamento">
    
    <div class="container-immagine">
        <div class="container-1024">
            <div class="col-xs-12 immagine-abbonamento">
                <img src="<?php echo $path_img ?>grafica-abbonamento.png" />
            </div>
        </div>
    </div>
    
    <div class="container-descrizione">
        <div class="container-1024">
            
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>		
                    <?php the_content(); ?>  
                <?php endwhile; ?>

            <?php endif; ?>

            <div class="container-form-paypal">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="KLYSRBDRVTCMY">
                    <input type="image" src="https://www.paypalobjects.com/it_IT/IT/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online.">
                    <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                </form>     
            </div>    
            
        </div>
        <div class="clear"></div> 
    </div>   
</div>
    


<?php get_footer(); ?>