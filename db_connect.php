<?php

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

?>