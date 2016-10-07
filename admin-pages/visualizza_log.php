<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

$printer = new LogView();

?>


<h1>Visualizza Log</h1>

<?php $printer->printAllLogs() ?>

<h1>Ricerca Log</h1>

<?php $printer->printFormRicerca() ?>

<?php $printer->listenerFormRicerca() ?>