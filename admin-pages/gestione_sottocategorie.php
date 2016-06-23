<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

$writer = new SottocategoriaView();

$writer->listnerTabellaInseriti();

?>

<h1>Gestione Sottocategorie</h1>



<?php 

    $writer->listenerFormInserimento();
    $writer->printFormInserimento(); 
        
?>

<h3>Sottocatgorie inserite</h3>

<?php $writer->printTabellaSottocategorieInserite() ?>