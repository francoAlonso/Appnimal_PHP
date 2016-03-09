<?php
	
class Usuario{

	public $id;
	private $Habilitado;
	public $Mail;

	public function getID(){
		return $this->id;
	}

	public function getMail(){
		return $this->Mail;
	}

	public function setMail($newMail){
		$this->Mail = $newMail;
	}

	//funciones para la base de datos:

	public static function obtenerTodos($pdo){

		$params = array();
		$statement = $pdo->prepare('
				SELECT *
				FROM Usuario
				WHERE Habilitado = 1
				');
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		return $statement->fetchAll(); // fetch trae uno solo. fetchAll trae todos los registros.

	}//obtenerTodos

	public static function ObtenerPorId($id, $pdo){

		$params = array(':ID' => $id);
		$statement = $pdo->prepare('
				SELECT *
				FROM Usuario
				WHERE id = :ID
				AND Habilitado = 1
				LIMIT 0,1');
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		return $statement->fetch();
		
	}//obtenerPorId

	public static function CrearUsuario($mail, $pdo){

		$params = array(':Mail' => $mail, ':Habilitado' => true);
		$statement = $pdo -> prepare('
			INSERT INTO Usuario
			(Mail, Habilitado)
			VALUES (:Mail, :Habilitado)');
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		return $statement->fetch();

	}//crearUsuario

	public static function Login($mail, $pdo){

		$params = array(':Mail' => $mail);
		$statement = $pdo->prepare('
			SELECT *
			FROM Usuario
			WHERE Mail = :Mail
			AND Habilitado = 1
			LIMIT 0,1');
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
		return $statement->fetch();

	}//Login

}//usuario

?>