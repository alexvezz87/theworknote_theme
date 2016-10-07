<?php

/**
 * Description of LogView
 *
 * @author Alex
 */
class LogView {
    private $controller;
    
    function __construct() {
        $this->controller = new LogController();
    }
    
    
    
    public function listenerFormRicerca(){
        
        if(isset($_POST['ricerca'])){
            $param = array();
            foreach($_POST as $k => $v){
                if($k != 'ricerca' && trim($v) != ''){
                    $param[$k] = trim($v);
                }
            }
            
            $logs = $this->controller->getLogs($param);
            
            echo '<p><strong>Log trovati: </strong>'.count($logs).'</p>';
            $this->printTable($logs);
            
        }
        
    }
    
    public function printFormRicerca(){        
        
        
        $mittenti = $this->controller->getDistinctFields('m');
        $destinatari = $this->controller->getDistinctFields('d');
        
        
    ?>    
        <script>
            jQuery( function($) {
                var availableDest = [
    <?php
                foreach($destinatari as $d){
                    echo '"'.$d.'",';
                }
    ?>
                ];
                
                var availableMitt = [
     <?php
                foreach($mittenti as $m){
                    echo '"'.$m.'",';
                }
    ?>
                ];            
                
                $( "#destinatario" ).autocomplete({
                    source: availableDest
                });
                $( "#mittente" ).autocomplete({
                    source: availableMitt
                });
                
          } );
        </script>
    

        <form class="form-ricerca" method="POST" action="<?php echo curPageURL() ?>">
            <div class="field tipo">
                <label>Tipo</label>
                <select name="tipo">
                    <option value=""></option>
                    <option value="invio mail">Invio Mail</option>
                    <option value="visualizza telefono">Visualizza telefono</option>                    
                </select>
            </div>
            <div class="field ui-widget">
                <label>Destinatario</label>
                <input id="destinatario" name="destinatario">
            </div>
            <div class="field ui-widget">
                <label>Mittente</label>
                <input id="mittente" name="mittente">
            </div>
            <div class="field ricerca">
                <input type="submit" name="ricerca" value="RICERCA" />
            </div>
            <div class="clear"></div>
        </form>
    <?php    
    }
    
    private function getUsers(){
        $users = get_users();
        $bp_users = array();
        foreach($users as $user){
            array_push($bp_users, getField($user->ID, 'Ragione Sociale'));
        }
        
        return $bp_users;
        
    }
    
    
    /**
     * La funzione stampa a video la tabella dei log, con un array passato 
     * @param type $logs
     */
    private function printTable($logs){
        if(count($logs) > 0){
    ?>
            <table class="table-cvs">
                <thead>
                    <tr class="intestazione">
                        <td>Data</td>
                        <td>Tipo</td>
                        <td>Mittente</td>
                        <td>Destinatario</td>
                    </tr>
                </thead>
                <tbody>
    <?php            
            foreach($logs as $log){
                $l = new Log();
                $l = $log;
    ?>
                    <tr>
                        <td><?php echo showCustomTime2($l->getDataLog()) ?></td>
                        <td><?php echo $l->getTipo() ?></td>
                        <td><?php echo $l->getMittente() ?></td>
                        <td><?php echo $l->getDestinatario() ?></td>
                    </tr>
    <?php           
            }
    
    ?>
                </tbody>
            </table> 
    <?php        
        }
        else{
            echo '<p>Nessun log da visualizzare</p>';
        }
    }
    
    
    public function printAllLogs(){
        $logs = $this->controller->getLogs(array('limit' => 10));
        
        $this->printTable($logs);
       
    }

}
