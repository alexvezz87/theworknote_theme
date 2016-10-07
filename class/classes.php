<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

//CLASSI MODEL
require_once 'model/Commento.php';
require_once 'model/Impostazione.php';
require_once 'model/Rinnovo.php';
require_once 'model/Sottocategoria.php';
require_once 'model/Log.php';

//CLASSI DAO
require_once 'DAO/CommentoDAO.php';
require_once 'DAO/ImpostazioneDAO.php';
require_once 'DAO/RinnovoDAO.php';
require_once 'DAO/SottocategoriaDAO.php';
require_once 'DAO/SottocategoriaUtenteDAO.php';
require_once 'DAO/SottocategoriaUtenteDisplayDAO.php';
require_once 'DAO/LogDAO.php';

//CLASSI CONTROLLER
require_once 'controller/CommentoController.php';
require_once 'controller/ImpostazioneController.php';
require_once 'controller/RinnovoController.php';
require_once 'controller/SottocategoriaController.php';
require_once 'controller/LogController.php';

//CLASSI VIEW
require_once 'view/CommentoView.php';
require_once 'view/ImpostazioneView.php';
require_once 'view/SottocategoriaView.php';
require_once 'view/LogView.php';

?>