<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImpostazioneView
 *
 * @author Alex
 */
class ImpostazioneView {
   
    private $controller;
    
    function __construct() {
        $this->controller = new ImpostazioneController();
    }

    public function printImpostazioneForm(){    
        //aggiungo il listener
        $this->listenerImpostazioniForm();
        
    ?>
        <div class="impostazioni-form-container">
            <form method="POST" action="<?php echo curPageURL() ?>">
                <div class="field">
                    <label>Nome Impostazione</label>
                    <input type="text" name="nome-impostazione" value="" required />
                </div>
                <div class="field">
                    <label>Valore Impostazione</label>
                    <input type="text" name="valore-impostazione" value="" required/>
                </div>
                <div class="field">                    
                    <input type="submit" name="salva-impostazione" value="SALVA" />
                </div>
            </form>            
            
        </div>
    <?php        
    }
    
    
    public function listenerImpostazioniForm(){
        if(isset($_POST['salva-impostazione'])){
            $i = new Impostazione();
            $nome = isset($_POST['nome-impostazione']) ? addslashes($_POST['nome-impostazione']) : null;
            $valore = isset($_POST['valore-impostazione']) ? addslashes($_POST['valore-impostazione']) : null;
            $i->setNome($nome);
            $i->setValore($valore);
            
            $this->controller->saveImpostazione($i);
        }
    }
    
    public function listenerTabellaImpostazioni(){
        if(isset($_POST['aggiorna-impostazione'])){
            $id = isset($_POST['id-impostazione']) ? stripslashes($_POST['id-impostazione']) : null;
            $valore = isset($_POST['valore-impostazione']) ? stripslashes($_POST['valore-impostazione']) : null;
            $i = new Impostazione();
            $i->setID($id);
            $i->setValore($valore);
            
            $this->controller->updateImpostazione($i);
        }
        if(isset($_POST['cancella-impostazione'])){
            $id = isset($_POST['id-impostazione']) ? stripslashes($_POST['id-impostazione']) : null;
            
            $this->controller->deleteImpostazione($id);
        }
    }
    
    public function printImpostazioni(){
        
        $this->listenerTabellaImpostazioni();
        
        $impostazioni = $this->controller->getImpostazioni();
        
        if(count($impostazioni) > 0){
    ?>        
        <table>
            <tr class="intestazione">
                <td>Nome</td>
                <td>Valore</td>                
            </tr>
    <?php
        foreach($impostazioni as $i){
            $impostazione = new Impostazione();
            $impostazione = $i;
    ?>            
            <tr>
                <td><?php echo stripslashes($impostazione->getNome()) ?></td>
                <td>
                    <form method="POST" action="<?php echo curPageURL() ?>">
                        <input type="text" name="valore-impostazione" required value="<?php echo stripslashes($impostazione->getValore()) ?>" />
                        <input type="hidden" name="id-impostazione" value="<?php echo $impostazione->getID() ?>" />
                        <input type="submit" name="aggiorna-impostazione" value="AGGIORNA" />
                        <input type="submit" name="cancella-impostazione" value="CANCELLA" />
                    </form>
                </td>
            </tr>
    <?php
        }
    ?>
        </table>
    <?php        
        }
        else{
            echo '<p>Non ci sono impostazioni presenti</p>';
        }
    }
}
