<?php

/**
 * Description of LogDAO
 *
 * @author Alex
 */
class LogDAO {
   private $wpdb;
   private $table;
   
   function __construct() {
       global $wpdb;
       $wpdb->prefix = 'twn_';
       $this->wpdb = $wpdb;
       $this->table = $wpdb->prefix.'logs';
   }
   
   function getWpdb() {
       return $this->wpdb;
   }

   function getTable() {
       return $this->table;
   }

   function setWpdb($wpdb) {
       $this->wpdb = $wpdb;
   }

   function setTable($table) {
       $this->table = $table;
   }

   /**
    * La funzione salva un Log nel database
    * @param Log $l
    * @return type
    */
    public function saveLog(Log $l){
        try{
            
            //imposto il timezone
            date_default_timezone_set('Europe/Rome');
            $timestamp = date('Y-m-d H:i:s', strtotime("now")); 
            
            $this->wpdb->insert(
                $this->table,
                array(
                    'mittente' => $l->getMittente(),
                    'destinatario' => $l->getDestinatario(),
                    'tipo' => $l->getTipo(),
                    'data_log' => $timestamp
                ),
                array('%s', '%s', '%s', '%s')                   
            );
            return $this->wpdb->insert_id;
       } catch (Exception $ex) {
           _e($ex);
           return -1;
       }
    }
    
    /**
     * La funzione restituisce un array di Log dati dei parametri passati
     * @param type $param
     * @return array
     */
    public function getLogs($param){
        try{
            $query = "SELECT * FROM ".$this->table." WHERE 1=1";
            if(isset($param)){
                foreach($param as $k => $v){
                    if($k != 'limit'){
                        $query.= " AND ".$k." LIKE '%".$v."%'";
                    }                
                }
            }
            
            $query.= " ORDER BY data_log DESC";
            
            //se indicato un limit nei parametri, lo inserisco, altrimenti ci do un massimo di 10
            if(isset($param['limit'])){
                $query.=" LIMIT ".$param['limit'];
            }
            
           
            $temp = $this->wpdb->get_results($query);
            $result = array();
            
            foreach($temp as $item){
                $l = new Log();
                $l->setID($item->ID);
                $l->setMittente($item->mittente);
                $l->setDestinatario($item->destinatario);
                $l->setTipo($item->tipo);
                $l->setDataLog($item->data_log);
                
                array_push($result, $l);
            }            
            return $result;
            
        } catch (Exception $ex) {
            _e($ex);
            return null;
        }
        
    }
    
    /**
     * La funzione resituisce un array di nomi scremati dalla clausola distinct
     * @param type $type
     * @return type
     */
    public function getDistinctFields($type){
        try{
            $field = "";
            if($type == 'm'){
                $field = "mittente";
            }
            else if($type == 'd'){
                $field = "destinatario";
            }
            
            $query = "SELECT DISTINCT ".$field." FROM ".$this->table;
            
            return $this->wpdb->get_col($query);            
            
        } catch (Exception $ex) {
            _e($ex);
            return null;
        }
    }


}
