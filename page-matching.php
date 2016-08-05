<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Matching page
 */

$printer = new SottocategoriaView();
$controller = new SottocategoriaController();

get_header();

$idUtente = get_current_user_id();
$printer->listenerSottocategorie();

?>

<div class="main-container preferenze" >
    
    
    <div class="main-content">
    
    <?php if($controller->isUtenteCompleto($idUtente)){ ?>    
        <div class="fascia-verde">
            <div class="container-1024">
                <div class="col-xs-12">
                    <h3>Professionisti o attività consigliati in base all'appartenenza e alle preferenze consigliate</h3>
                </div>
                <div class="clear"></div>            
            </div>            
        </div>
        <div class="fascia-verde-chiaro">
            <div class="container-1024">
                <div class="col-xs-12 visible-md visible-lg">               
                    <?php echo $printer->printMatching($idUtente) ?>
                </div>
                <div class="col-xs-12 visible-sm ">               
                    <?php echo $printer->printMatching($idUtente, 2) ?>
                </div>
                <div class="col-xs-12 visible-xs">               
                    <?php echo $printer->printMatching($idUtente, 1) ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    <?php } ?>
        <div class="fascia-verde">
            <div class="container-1024">
                <div class="col-xs-12">
                    <h3>Appartenenza</h3>
                </div>
                <div class="clear"></div>         
            </div>
        </div>
        <div class="container-preferenze">
            <div class="container-1024">
                
                    <?php                
                        $printer->printAllSottoCategorie('a', $idUtente);                    
                    ?>
                
            </div>
            <div class="clear"></div> 
        </div>
        <div class="fascia-verde">
            <div class="container-1024">
                <div class="col-xs-12">
                    <h3>Preferenze</h3>
                </div>
                <div class="clear"></div>         
            </div>
        </div>   
        <div class="container-preferenze">
            <div class="container-1024">
                
                    <?php                
                        $printer->printAllSottoCategorie('p', $idUtente);            
                    ?>
               
            </div>
            <div class="clear"></div> 
        </div>           
        
    </div>
</div>


<?php get_footer(); ?>