<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

$view = new ImpostazioneView();

?>

<h2>Impostazioni</h2>

<h3>Inserisci impostazione</h3>
<?php echo $view->printImpostazioneForm() ?>

<h3>Impostazioni presenti</h3>
<?php echo $view->printImpostazioni() ?>