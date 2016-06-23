<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Matching page
 */

$printer = new SottocategoriaView();

get_header();

$idUtente = get_current_user_id();
$printer->listenerSottocategorie();

?>

<div class="main-container preferenze" >
    
    
    <div class="main-content">
        <div class="container-1024">
            
            <div class="col-xs-12">
                <h3>Consigliati</h3>
                <?php echo $printer->printMatching($idUtente) ?>
            </div>
            
            
            <div class="col-xs-12 col-sm-6">
                <?php                
                    $printer->printAllSottoCategorie('a', $idUtente);                    
                ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?php                
                    $printer->printAllSottoCategorie('p', $idUtente);                    
                ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>


<?php get_footer(); ?>