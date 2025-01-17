<?php
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__."/../model/UserMapper.php");

/**
* Class BaseRest
*
* Superclass for Rest endpoints
*
* It simply contains a method to authenticate users via HTTP Basic Auth against
* the Usuario database via UserMapper.
*
* @author lipido <lipido@gmail.com>
*/


class BaseRest {

    const DIRECTORA = 0;
    const SECRETARIA = 1;
    const COCINERA = 2;
    const RESIDENTE = 3;

	public function __construct() { }

	/**
	* Authenticates the current request. If the request does not contain
	* auth credentials, it will generate a 401 response code and end PHP processing
	* If the request contain credentials, it will be checked against the database.
	* If the credentials are ok, it will return the Usuario object just logged. If the
	* credentials are invalid, it will generate a 401 code as well and end PHP
	* processing.
	*
	* @return Usuario the user just authenticated.
	*/
	public function usuarioAutenticado() {


		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
			header('WWW-Authenticate: Basic realm="REST API ResidenciaAPP"');
			die('Necesitas loguearte');
		}
		else {
			$userMapper = new UserMapper();
			if ($userMapper->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
                $userArray = $userMapper->getUsiarioByEmail($_SERVER['PHP_AUTH_USER']);
                return new Usuario($userArray['email'],$userArray['nombre'],$userArray['apellidos'],$userArray['dni'],null,$userArray['contraseña'],$userArray['rol']);

            } else {
				header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
				header('WWW-Authenticate: Basic realm="REST ResidenciaRest"');

				die('No tienes permiso');
			}
		}
	}

	public function verificarRol(array $roles) : Usuario {
	    $usuario = $this->usuarioAutenticado();
	    $coincide = false;
	    foreach ($roles as $rol){
            if ($usuario->getRol()== $rol) $coincide=true;
        }
	    if(!$coincide){
            header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="REST ResidenciaAPP"');
            die('No tienes permisos para realizar esta acción');
        }
	    else return $usuario;
    }
}
