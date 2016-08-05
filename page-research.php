<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Research page
 */

$printer = new SottocategoriaView();

get_header();

$idUtente = get_current_user_id();
$printer->listenerSottocategorie();

?>

<div class="main-container ricerca" >
    
    
    <div class="main-content">
        <div class="container-1024">
            
           
            <div class="col-xs-12">
                <script>
                    (function() {
                      var cx = '000863887762990355974:zniw3xmxqmi';
                      var gcse = document.createElement('script');
                      gcse.type = 'text/javascript';
                      gcse.async = true;
                      gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                      var s = document.getElementsByTagName('script')[0];
                      s.parentNode.insertBefore(gcse, s);
                    })();
                </script>
                <gcse:search></gcse:search>
            </div>
            
            
           
            <div class="clear"></div>
        </div>
    </div>
</div>


<?php get_footer(); ?>