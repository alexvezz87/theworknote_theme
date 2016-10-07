<?php

/**
 * Description of LogController
 *
 * @author Alex
 */
class LogController {
    private $DAO;
    
    function __construct() {
        $this->DAO = new LogDAO();
    }
    
    function getDAO() {
        return $this->DAO;
    }

    function setDAO($DAO) {
        $this->DAO = $DAO;
    }

    /**
     * La funzione salva un log nel sistema
     * @param Log $l
     * @return type
     */
    public function saveLog(Log $l){
        return $this->DAO->saveLog($l);
    }
    
    
    public function getLogs($param){
        return $this->DAO->getLogs($param);
    }
    
    
    public function getDistinctFields($type){
        return $this->DAO->getDistinctFields($type);
    }

    
}
