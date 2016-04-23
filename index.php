<?php

require 'Slim-2.6.2/Slim/Slim.php';
require 'db_connect.php';
require 'db_config.php';

require 'script/objects/Usuario.php';

require 'script/controllers/UsuarioController.php';


// Permite el acceso desde otros dominios (CORS) - INICIO
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}
// Permite el acceso desde otros dominios (CORS) - FIN

date_default_timezone_set('America/Argentina/Buenos_Aires');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$db_config = new Db_config();
$pdo = new db_connect("mysql:host=" . $db_config->server . ";dbname=" . $db_config->database, $db_config->username, $db_config->password);

$app->get('/usuario', function () use ($app, $pdo){

    try{

        $listaUsuario = UsuarioController::ObtenerTodos($pdo);
        echo json_encode($listaUsuario);
    }
    catch (Exception $ex){

        $app->response->setStatus(500);
        echo $ex->getMessage();
    }

});//usuario

$app->get('/usuario/mail/:mail', function($mail) use ($app, $pdo){

    try{
       // $datosRecibidos = json_decode($app->request->get('Mail'));
        $usuario = UsuarioController::ObtenerPorMail($mail, $pdo);
        echo json_encode(array($usuario));
    }catch(Exception $ex){

        $app->response->setStatus(500);
        echo $ex->getMessage();
    }
});//usuario->mail

$app->get('/usuario/:id', function($id) use ($app, $pdo){

    try{

        $usuario = UsuarioController::ObtenerPorId($id, $pdo);
        echo json_encode(array($usuario));

    }catch(Exception $ex){

        $app->response->setStatus(500);
        echo $ex->getMessage();
    }

});//usuario->id

$app->get('/usuario/login', function() use ($app, $pdo) {

    try{
        $usuario = null;
        $respuesta = false;

        $datosRecibidos = json_decode($app->request->getBody());
        $usuario = UsuarioController::Login($datosRecibidos->Mail, $pdo);

        if ($usuario == null){
            $respuesta = false;
        }else{
            $respuesta = true;
        }
        
        echo json_encode(array("Validado" => $respuesta, "Usuario" => $usuario));

    }
    
    catch (Exception $ex){

        $app->response->setStatus(500);
        echo $ex->getMessage();

    }

});//Login


$app->run(); //corre los resultados

?>