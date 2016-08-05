<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

$impController = new ImpostazioneController();

$args = array(
    'role' => 'subscriber',
    'orderby'      => 'registered',
    'order'        => 'ASC',
);

$users = get_users($args);

/*
 * La funzionalità di scadenza funziona in diverso modo. Eistono due Categorie da controllare
 * A. Gli utenti in prova gratuita (cioè quelli che si sono registrati per la prima volta e la durata della prova gratuita è indicata dalle impostazioni)
 * B. Gli utenti con abbonamento attivo (cioè quelli che hanno rinnovato e la scadenza è indicata dalle impostazioni)
 * 
 * Procedimento:
 * 1. Controllare se gli utenti hanno rinnovato --> Tabella twn_rinnovo
 * 2. Se non sono presenti, allora sono in prova gratuita.
 * 2a. In questo caso si effettua il controllo sulla durata del periodo di prova gratuita indicato dalle impostazioni
 * 3. Sono presenti nella tabella rinnovo.
 * 3a. Si effettua il controllo sul periodo di abbonamento indicato dalle impostazioni.
 * 
 */

//LISTENER
if(isset($_POST['rinnova-utente'])){        
    $idUtente = isset($_POST['id-utente']) ? $_POST['id-utente'] : null;
    if($idUtente != null){
        $cRinn = new RinnovoController();
        $cRinn->rinnovaUtente($idUtente);
    }
}

if(isset($_POST['blocca-utente'])){
    //questo listener si preoccupa di cambiare il valore dello user_status da 0 a 1
    $idUtente = isset($_POST['id-utente']) ? $_POST['id-utente'] : null;
    if($idUtente != null){
        updateUserStatus($idUtente, 1);
    }
}

if(isset($_POST['sblocca-utente'])){
    //questo listener si preoccupa di cambiare il valore dello user_status da 0 a 1
    $idUtente = isset($_POST['id-utente']) ? $_POST['id-utente'] : null;
    if($idUtente != null){
        updateUserStatus($idUtente, 0);
    }
}

$utenti = calcolaScadenzaUtenti($users);

?>


    <h1>Gestione utenti</h1>

<div>
    <?php     
        printTabelleUtenti($utenti);
    ?>
</div>

