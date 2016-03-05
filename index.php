<?php

require 'Slim-2.6.2/Slim/Slim.php';
require 'db_connect.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $mail = $_POST['mail'];

        $db = new DB_CONNECT();
        $db->connect();

        $res = logeo($mail);
        if($res == true){
            echo "esta registrado";
        }else{
            $comando = "INSERT INTO .usuario (id, Habilitado, Mail, Numero) VALUES (null, '1', '$mail', 12345678)";
            mysql_query($comando) or die ("problema al agregar");
            echo "parece andar";
        }
    }

    function logeo($mail){

        $comando = "SELECT * FROM usuario WHERE mail = '$mail'";

        $rec = mysql_query($comando) or die ("problema en seleccion");
        $count = 0;
        while($row=mysql_fetch_row($rec)){
            $count++;
        }
        if($count==1){
            return true;
        }else{
            return false;   
        } 

    }//logeo

?>