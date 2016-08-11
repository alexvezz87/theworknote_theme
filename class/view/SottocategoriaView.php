<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SottocategoriaView
 *
 * @author Alex
 */
class SottocategoriaView {
    private $controller;
    private $impostazioni;
    
    function __construct() {
        $this->controller = new SottocategoriaController();
        $this->impostazioni = new ImpostazioneController();
    }
    
    function getController() {
        return $this->controller;
    }

    function setController($controller) {
        $this->controller = $controller;
    }

        
    
    /**
     * Stampo il form di inserimento delle sottocategorie
     */
    public function printFormInserimento(){

    ?>
        <form action="<?php echo curPageURL() ?>" method="POST">
            <div class="field">
                <label>Categoria Commerciale</label>
                <?php echo $this->getSelectCategoriaCommerciale2() ?>
            </div>
            <div class="field">
                <label>Nome Sottocategoria</label>
                <input type="text" name="sottocategoria" value="" />
            </div>
            <div class="field">
                <input type="submit" name="add-sottocategoria" value="INSERISCI" />
            </div>
        </form>
    <?php
        
    }
    
    /**
     * Stampa la select delle macro categorie
     * @return string
     */
    private function getSelectCategoriaCommerciale2(){
    
        $categorie = getValueCategoriaCommerciale();
        $html = "";


        if(count($categorie) > 0){       
            $html.= '<select class="categoria-commerciale" name="categoria" required>';

            for($i=0; $i < count($categorie); $i++){          
                $html.= '<option value="'.$categorie[$i]->name.'">'.stripslashes($categorie[$i]->name).'</option>';            
            }

            $html.= '</select>';
        }

        return $html;    
    }
    
    /**
     * Ascoltatore del Form di Inserimento 
     */
    public function listenerFormInserimento(){
        if(isset($_POST['add-sottocategoria'])){
           $categoria = (isset($_POST['categoria']) && $_POST['categoria'] != '' ) ? $_POST['categoria'] : null;
           $sottoCategoria = (isset($_POST['sottocategoria']) && $_POST['sottocategoria'] != '' ) ? $_POST['sottocategoria'] : null;
           
           if($categoria != null && $sottoCategoria != null){
               //salvo il valore nel database
               $s = new Sottocategoria();
               $s->setNome($sottoCategoria);
               $s->setNomeMacroCategoria($categoria);
               if($this->controller->saveSottocategoria($s) == false){
                   echo '<p>Sottocategoria già assegnata a '.$categoria.'</p>';
               }
           }
           else{
               echo '<p>Qualcosa è andato storto</p>';
           }
        }
    }
    
    /**
     * La funzione stampa una tabella contenete le sottocategorie inserite nel database
     */
    public function printTabellaSottocategorieInserite(){
    
        $parameters['order'] = 'nome_macro_categoria';
        $sottocategorie = $this->controller->getSottocategorie($parameters);
        
        if(count($sottocategorie) > 0){
    ?>
        <table class="table-cvs">
            <thead>
                <tr class="intestazione">
                    <td>Categoria</td>
                    <td>Nome Sottocategoria</td>
                    <td>Azione</td>
                </tr>
            </thead>
            <tbody>
    <?php            
            foreach($sottocategorie as $sottocategoria){
                $s = new Sottocategoria();
                $s = $sottocategoria;
    ?>
                <tr>
                    <td><?php echo stripslashes($s->getNomeMacroCategoria()) ?></td>
                    <td><?php echo $s->getNome() ?></td>
                    <td>
                        <form action="<?php echo curPageURL() ?>" method="POST">
                            <input type="hidden" name="id-sottocategoria" value="<?php echo $s->getID() ?>" />
                            <input type="submit" name="elimina-sottocategoria" value="ELIMINA" />
                        </form>
                    </td>
                </tr>
    <?php
            }
    ?>
            </tbody>
        </table>
    <?php
        }
        else{
            echo '<p>Non ci sono sottocategorie da visualizzare.</p>';
        }
        
    }
    
    /**
     * Listener della tabella inserimento
     */
    public function listnerTabellaInseriti(){
        if(isset($_POST['elimina-sottocategoria'])){
            $id = isset($_POST['id-sottocategoria']) ? $_POST['id-sottocategoria'] : null;
            if($id != null){
                if(!$this->controller->deleteSottocategoria($id)){
                    echo '<p>Errore nella rimozione della sottocategoria</p>';
                }
            }
        }
    }
    
    
    public function printAllSottoCategorie($tipo, $idUtente){        
        $categorie = array();
        $sottocategoria = "";
        $titolo = "";
        if($tipo == 'a'){
            $titolo = 'Appartenenza';
            $sottocategoria = 'appartenenza';            
            //$categorie = getCategoriaByUser($idUtente);
            $categorie = getValueCategoriaCommerciale();
        }
        else{
            $titolo = 'Preferenze';
            $sottocategoria = 'preferenze';
            $categorie = getValueCategoriaCommerciale();
        }
        
    ?>
        <form action="<?php echo curPageURL()?>" name="<?php echo $tipo ?>" method="POST">        
        <input type="hidden" name="id-utente" value="<?php echo get_current_user_id() ?>">
    <?php
        foreach($categorie as $categoria){
            $parameters['macroCategoria'] = $categoria->name;            
            $sub = $this->controller->getSottocategorie($parameters);
            
            if(count($sub) > 0){
    ?>
                <div class="container-categoria">
                    <div class="col-xs-12 col-sm-6 titolo-categoria">                   
                        <h3><?php echo stripslashes($categoria->name) ?></h3>                    
                    </div>
                    <div class="col-xs-12 col-sm-6 categorie-list">
                        <ul>
    <?php
                foreach ($sub as $i){
                    $s = new Sottocategoria();
                    $s = $i;
                    $checked = "";
                    if($this->controller->isSottoCategoriaAssignedToUtente($idUtente, $s->getID(), $tipo) == true){
                        $checked = "checked";
                    }
    ?>
                        <li><label class="checkbox-inline"><input class="sottocategorie" type="checkbox" name="<?php echo $sottocategoria ?>[]" value="<?php echo $s->getID() ?>" <?php echo $checked ?> /><?php echo $s->getNome() ?></label></li>
    <?php            
                }
    ?>                
                        </ul>
                    </div>
                    <div class="clear separatore"></div>
                </div>
    <?php
            }
        }
    ?>
        <!--
        <div class="col-xs-12 col-sm-6 col-sm-push-6">            
            <input class="select-all" type="checkbox" name="select-all" value="" /><label>Seleziona tutti</label>
            <input class="deselect-all" type="checkbox" name="deselect-all" value="" /><label>Deseleziona tutti</label>
        </div>
        -->
        <div class="clear">
            <input type="submit" name="salva-<?php echo $sottocategoria ?>" value="AGGIORNA <?php echo strtoupper($titolo) ?>" />
        </div>
        </form>
    <?php
    }
    
    
    public function listenerSottocategorie(){
        if(isset($_POST['salva-appartenenza'])){
            $idUtente = $_POST['id-utente'];
            $this->controller->deleteSottoCategoriaByUtente($idUtente, 'a');
            if(count($_POST['appartenenza']) > 0){                
                foreach($_POST['appartenenza'] as $value){                
                    $this->controller->saveSottoCategoriaUtente($value, $idUtente, 'a');
                }
            }
           
        }
        
        if(isset($_POST['salva-preferenze'])){
            $idUtente = $_POST['id-utente'];
            $this->controller->deleteSottoCategoriaByUtente($idUtente, 'p');
            if(count($_POST['preferenze']) > 0){               
                foreach($_POST['preferenze'] as $value){
                    $this->controller->saveSottoCategoriaUtente($value, $idUtente, 'p');
                }
            }            
        }
    }
    
    /**
     * Funzione che stampa a video gli utenti che fanno match con un determinato utente passato come parametro
     * @param type $idUtente
     */
    public function printMatching($idUtente, $mode = 4, $widget = false){
                
        //mode = 1 --> carosello da 1
        //mode = 2 --> carosello da 2
        //mode = 4 --> carosello da 4
    
        $matched = $this->controller->matchingByUtente($idUtente);
        
        //misure di un singolo match (widht + margin-right)
        $singleElement = 175+45;
        //$maxElement = 9;
        
        //calcolo lunghezza ul
        $ulWidth = count($matched) * $singleElement;
        
        $ulContainerWidht = $mode * $singleElement;
       
        
        $widthCarusel =  ($ulContainerWidht + 60).'px';
        
        if($mode == 4){
            $widthCarusel = '100%';
        }
        
        if(count($matched) > 0){
            
            if($widget == true){
    ?>    
            <div class="fascia-verde banner">
                <div class="col-xs-12">
                    <h3>Professionisti o attività consigliati</h3>
                </div>
            </div>
    <?php
            
        }
            
            echo '<input type="hidden" name="url" value="'.get_home_url().'/wp-admin/admin-ajax.php" />';
            echo '<input type="hidden" name="liWidth" value="'.$singleElement.'" />';
            echo '<input type="hidden" name="ulWidth" value="'.$ulContainerWidht.'" />';
                        
            echo '<input type="hidden" name="isWidget" value="'.$mode.'" />';
           
            
            echo '<div class="pagina-matching carusel" style="width:'.$widthCarusel.'">';
            echo '  <div class="arrow avanti"></div>';
            echo '  <div class="container-ul" style="width:'.$ulContainerWidht.'px">';
            
            echo '      <ul class="matching" style="width:'.$ulWidth.'px">';
            foreach($matched as $m){
                //url dell'immagine dell'avatar
                $img = bp_core_fetch_avatar(  array( 'item_id' => $m, 'html' => false ) );
                $url = bp_core_get_userlink($m, false, true);
                $user_info = get_userdata($m);
                $categoria = getValueCategoriaByUser($user_info->ID);
                
                echo '      <li>';
                echo '          <a href="'.$url.'" target="_blank">';
                echo '              <img class="avatar-50" src="'.$img.'" />';
                echo '          </a>';                
                echo '          <a class="testo" href="'.$url.'" target="_blank">';
                echo '              <span class="nome-utente">'.$user_info->display_name.'</span><br>';
                echo '              <span class="categoria">'.$categoria.'</span>';
                echo '          </a>';               
                echo '          <div class="buttons">';
                echo '              <form action="'.$url.'" method="POST">';
                echo '                  <input type="hidden" name="id-utente" value="'.$idUtente.'" />';
                echo '                  <input type="hidden" name="id-utente-proposto" value="'.$m.'" />';
                echo '                  <input style="float:left" class="button visualizza" type="submit" value="VISUALIZZA" />';
                echo '                  <input style="float:right" class="button rimuovi-proposto" name="rimuovi-proposto" type="button" value="RIMUOVI" />';
                echo '              </form>';
                echo '          </div>';
                echo '      </li>';
            }
            
            echo '      </ul>';
            echo '  </div>';
            echo '  <div class="arrow indietro"></div>';        
            echo '  <div class="clear"></div>';
            echo '</div>';
        }
        else{
            if($mode == 4){
                echo '<p class="no-match">PER ORA NESSUN UTENTE CORRISPONDE ALLE TUE PREFERENZE</p>';
            }
            else{
        ?>
            <div class="banner-preferenze">
                <h3>
                    Vuoi avere più contatti tra clienti e fornitori?
                </h3>
                <form action="<?php echo home_url() ?>/preferenze" method="POST">
                    <input type="submit" value="Scopri come" />
                </form>
            </div>
        <?php
            }
        }
        
       
        
        
        
        /*
        //stampa fittizia
        echo '<div class="pagina-matching carusel">';
        echo '<div class="arrow avanti"><<</div>';
        echo '<div class="container-ul" style="width:'.$ulContainerWidht.'px">';
        echo '<ul class="matching" style="width:'.$ulWidth.'px">';
        for($i=0; $i < $maxElement; $i++){
            echo '<li>';
            echo '<a href="#" target="_blank">';
            echo '<img class="avatar-50" src="'.get_template_directory_uri().'/images/avatar-fake.png" />';
            echo '</a>';
            echo '<a class="testo" href="#" target="_blank">';
            echo '<span class="nome-utente">Utente con il nome lungo lungo '.$i.'</span><br>';
            echo '<span class="categoria">Casalinghi, Giochi, Regalistica</span>';
            echo '</a>';
            echo '<input type="hidden" name="id-utente" value="Utente-'.$i.'" />';
            echo '<input type="hidden" name="id-utente-proposto" value="utente-'.$i.'" />';
            echo '<div class="buttons">';
            echo '<form action="'.$url.'" method="POST">';
            echo '<input class="button visualizza" type="submit" value="VISUALIZZA" />';
            echo '<input class="button rimuovi-proposto" name="rimuovi-proposto" type="button" value="RIMUOVI" />';
            echo '</form>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<div class="arrow indietro">>></div>';        
        echo '<div class="clear"></div>';
        echo '</div>';
        */
        
    }
    
    
    public function printWidgetMatching($idUtente, $mode){
        
        //controllo se nelle impostazioni il matching è attivo
        if(intval($this->impostazioni->getImpostazioneByNome('attiva-matching')) == 1){
        
            if($this->controller->isUtenteCompleto($idUtente)){
                //l'utente ha compilato le tabelle
    ?>

    <?php           
                $this->printMatching($idUtente, $mode, true);
            }
            else{
                //l'utente non ha compilato le tabelle
    ?>
                <div class="banner-preferenze">
                    <h3>
                        Vuoi avere più contatti tra clienti e fornitori?
                    </h3>
                    <form action="<?php echo home_url() ?>/preferenze" method="POST">
                        <input type="submit" value="Scopri come" />
                    </form>
                </div>
    <?php

            }
        }
    }
    

}
