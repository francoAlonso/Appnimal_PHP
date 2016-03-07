<?php

class UsuarioController{

	public static function ObtenerTodos($pdo){

		$listaUsuarios = Usuario::ObtenerTodos($pdo);
		return $listaUsuarios;

	}//obtenerTodos

	public static function ObtenerPorId($id, $pdo){

		$usuario = Usuario::ObtenerPorId($id, $pdo);
		return $usuario;

	}//obtenerPorId

	public static function Login($mail, $pdo){

		$usuario = Usuario::Login($mail, $pdo);
		return $usuario;

	}//Login

}

?>