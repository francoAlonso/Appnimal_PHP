<?php

class DB_CONNECT extends PDO{

    protected $transactionCounter = 0;

    public function beginTransaction() {

        if(!$this::$transactionCounter++) {
            return parent::beginTransaction();
        }
        $this->exec('SAVEPOINT trans'.$this->transactionCounter);
        return $this->transactionCounter >= 0;

    }//beginTransaction

    public function commit() {

        if(!--$this->transactionCounter) {
            return parent::commit();
        }
        return $this->transactionCounter >= 0;

    }//commit

    public function rollBack() {

        if (!--$this->transactionCounter) {
            $this->exec('ROLLBACK TO trans'.$this->transactionCounter + 1);
            return true;
        }
        return parent::rollback();
        
    }//rollBack

}//db_connect

/*
class DB_CONNECT{

    function connect(){
        // import database connection variables
        require 'db_config.php';
        // Connecting to mysql database
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
        // Selecing database
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());
    }

    function close() {
    // closing db connection
        mysql_close();
    }
}
*/
?>