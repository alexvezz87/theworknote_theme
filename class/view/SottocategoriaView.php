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
    
    function __construct() {
        $this->controller = new SottocategoriaController();
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
            $categorie = getCategoriaByUser($idUtente);
        }
        else{
            $titolo = 'Preferenze';
            $sottocategoria = 'preferenze';
            $categorie = getValueCategoriaCommerciale();
        }
        
    ?>    
        <form action="<?php echo curPageURL()?>" name="<?php echo $tipo ?>" method="POST">
        <h2><?php echo $titolo ?></h2>
        <input type="hidden" name="id-utente" value="<?php echo get_current_user_id() ?>">
    <?php
        foreach($categorie as $categoria){
            $parameters['macroCategoria'] = $categoria->name;            
            $sub = $this->controller->getSottocategorie($parameters);
            
            if(count($sub) > 0){
    ?>
                <h3><?php echo stripslashes($categoria->name) ?></h3>
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
                    <li><input class="sottocategorie" type="checkbox" name="<?php echo $sottocategoria ?>[]" value="<?php echo $s->getID() ?>" <?php echo $checked ?> /><label><?php echo $s->getNome() ?></label></li>
    <?php            
                }
    ?>                
                </ul>
    <?php
            }
        }
    ?>
        <div>
            <input class="select-all" type="checkbox" name="select-all" value="" /><label>Seleziona tutti</label>
            <input class="deselect-all" type="checkbox" name="deselect-all" value="" /><label>Deseleziona tutti</label>
        </div>
        <input type="submit" name="salva-<?php echo $sottocategoria ?>" value="AGGIORNA <?php echo strtoupper($titolo) ?>" />
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
    public function printMatching($idUtente){
    
        $matched = $this->controller->matchingByUtente($idUtente);
        
        if(count($matched) > 0){
            echo '<input type="hidden" name="url" value="'.get_home_url().'/wp-admin/admin-ajax.php" />';
            echo '<ul class="matching">';
            foreach($matched as $m){
                //url dell'immagine dell'avatar
                $img = bp_core_fetch_avatar(  array( 'item_id' => $m, 'html' => false ) );
                $url = bp_core_get_userlink($m, false, true);
                $user_info = get_userdata($m);
                echo '<li>';
                echo '<a href="'.$url.'" target="_blank">';
                echo '<img class="avatar-50" src="'.$img.'" />';
                echo '<span>'.$user_info->display_name.'</span>';
                echo '</a>';
                echo '<input type="hidden" name="id-utente" value="'.$idUtente.'" />';
                echo '<input type="hidden" name="id-utente-proposto" value="'.$m.'" />';
                echo '<input class="rimuovi-proposto" name="rimuovi-proposto" type="button" value="RIMUOVI" />';
                echo '</li>';
            }
            
            echo '</ul>';
        }
        else{
            echo '<p>nessun match trovato :(</p>';
        }
    }

}
