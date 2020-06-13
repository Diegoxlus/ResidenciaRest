<?php
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__ . "/BaseRest.php");
require_once(__DIR__."/../model/ConfiguracionMapper.php");


/**
* Class UsuarioRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
class UsuarioRest extends BaseRest {
	private $userMapper;
	private $configuracionMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();
		$this->configuracionMapper = new ConfiguracionMapper();

	}

	public function register() {

        $configuracionData = $this->configuracionMapper->getConfiguracion();
        if(empty($configuracionData)){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Contacta con la directora, no están configurado el registro manual"));
            exit();
        }
        $configuracion = new Configuracion($configuracionData['id'],$configuracionData['hora_comida'],$configuracionData['hora_cena'],$configuracionData['limite_hora_comida'],$configuracionData['limite_hora_cena'],$configuracionData['registro']);
        if($configuracion->getRegistro()==0){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Contacta con la directora, no está activado el registro manual"));
            exit();
        }

	    $data = $_POST['usuario'];
	    $data = json_decode($data,true);
		$user = new Usuario($data['_email'],$data['_nombre'],$data['_apellidos'],$data['_dni'],$data['_f_nac'],$data['_pass'],$data['_rol']);

		if($this->userMapper->emailExists($user->getEmail())){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("El email ya existe"));
            exit();
        }
		try {
			$user->verificar();
			$this->userMapper->registrarUsuario($user);
            http_response_code(201);
            header('Content-Type: application/json');
		}catch(ValidationException $e) {
			http_response_code(400);
			header('Content-Type: application/json');
			echo(json_encode($e->getError()));
		}catch(Exception $e) {
            http_response_code(406);
            header('Content-Type: application/json');
            echo(json_encode($e->getMessage()));
        }

	}

    public function registroManual() {
        parent::verificarRol([0,1]);
        $data = $_POST['usuario'];
        $data = json_decode($data,true);
        $user = new Usuario($data['_email'],$data['_nombre'],$data['_apellidos'],$data['_dni'],$data['_f_nac'],$data['_pass'],$data['_rol']);

        if($this->userMapper->emailExists($user->getEmail())){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("El email ya existe"));
            exit();
        }

        try {
            $user->verificar();
            $this->userMapper->registrarUsuario($user);
            header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
            echo(json_encode(true));
            exit();
        }catch(ValidationException $e) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getError()));
        }catch(Exception $e) {
            http_response_code(406);
            header('Content-Type: application/json');
            echo(json_encode($e->getMessage()));
        }

    }

	public function login($email) {
		$currentLogged = parent::usuarioAutenticado();
		if ($currentLogged->getEmail() != $email) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("El email no corresponde.");
		} else {
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode($currentLogged->jsonSerialize()));
		}
	}

	public function getResidentes(){
	    //parent::usuarioAutenticado();
	    $userArray = $this->userMapper->getResidentes();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function getResidentesHabitacion(){
        parent::verificarRol([0,1]);
        $userArray = $this->userMapper->getResidentesHabitacion();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function getTrabajadores(){
        $userArray = $this->userMapper->getTrabajadores();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($userArray));
    }

    public function eliminarTrabajador($email){
	    $userArray = $this->userMapper->getUsiarioByEmail($email);
        $usuario = new Usuario($userArray['email'],$userArray['nombre'],$userArray['apellidos'],$userArray['dni'],$userArray['f_nac'],$userArray['contraseña'],$userArray['rol']);
        $rol = $usuario->getRol();

        if($usuario->getRol()==3){
            http_response_code(400);
            header('Content-Type: application/text');
            echo("Este usuario no es un trabajador");
        }
        else{
            $resul = $this->userMapper->eliminarUsuario($usuario);
            if($resul==1){
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                echo(json_encode(true));
            }
            else if($resul==0){
                header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
                echo("Error al ejecutar la sentencia de eliminacion");

            }
            else{
                header($_SERVER['SERVER_PROTOCOL'].' 406 Not Acceptable');
                echo("Error desconocido al ejecutar la sentencia de eliminacion");
            }
        }

    }

    public function eliminarResidente($email){
	    parent::verificarRol([0,1]);
        $userArray = $this->userMapper->getUsiarioByEmail($email);
        $usuario = new Usuario($userArray['email'],$userArray['nombre'],$userArray['apellidos'],$userArray['dni'],$userArray['f_nac'],$userArray['contraseña'],$userArray['rol']);
        $rol = $usuario->getRol();

        if($usuario->getRol()!=3){
            http_response_code(400);
            header('Content-Type: application/text');
            echo("Este usuario no es un residente");
        }
        else{
            $resul = $this->userMapper->eliminarUsuario($usuario);
            if($resul==1){
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                echo(json_encode(true));
            }
            else if($resul==0){
                header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
                echo("Error al ejecutar la sentencia de eliminacion");

            }
            else{
                header($_SERVER['SERVER_PROTOCOL'].' 406 Not Acceptable');
                echo("Error desconocido al ejecutar la sentencia de eliminacion");
            }
        }

    }

    public function modificarResidente($email){
	    parent::verificarRol([0,1]);
        $data = $_POST['residente'];
        $data = json_decode($data,true);
        $userArray = $this->userMapper->getUsiarioByEmail($email);
        $usuarioExistente = new Usuario($userArray['email'],$userArray['nombre'],$userArray['apellidos'],$userArray['dni'],$userArray['f_nac'],$userArray['contraseña'],$userArray['rol']);
        $usuarioNuevo = new Usuario($data['_email'],$data['_nombre'],$data['_apellidos'],$data['_dni'],$data['_f_nac'],$data['_pass'],$data['_rol']);

        if($usuarioExistente->getRol()!=3){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("El usuario no es un residente"));
            exit();
        }
        $this->modificarUsuario($usuarioExistente,$usuarioNuevo);

        if($this->userMapper->cambiarDatos($usuarioExistente)){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            echo(json_encode(true));
            exit();
        }
        else{
            header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
            echo("Error interno del servidor");
        }
    }

    public function modificarTrabajador($email){
	    parent::verificarRol([0,1]);
        $data = $_POST['trabajador'];
        $data = json_decode($data,true);
        $userArray = $this->userMapper->getUsiarioByEmail($email);
        $usuarioExistente = new Usuario($userArray['email'],$userArray['nombre'],$userArray['apellidos'],$userArray['dni'],$userArray['f_nac'],$userArray['contraseña'],$userArray['rol']);
        $usuarioNuevo = new Usuario($data['_email'],$data['_nombre'],$data['_apellidos'],$data['_dni'],$data['_f_nac'],$data['_pass'],$data['_rol']);

        if($usuarioExistente->getRol()==3){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("El usuario no es un trabajador"));
            exit();
        }
        $this->modificarUsuario($usuarioExistente,$usuarioNuevo);

        if($this->userMapper->cambiarDatos($usuarioExistente)){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            echo(json_encode(true));
            exit();
        }
        else{
            header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error');
            echo("Error al ejecutar la sentencia de edicion");
        }
    }

    public function  modificarUsuario(Usuario $usuarioExistente,Usuario $usuarioNuevo){
	    $usuarioExistente->setNombre($usuarioNuevo->getNombre());
	    $usuarioExistente->setApellidos($usuarioNuevo->getApellidos());
	    $usuarioExistente->setDni($usuarioNuevo->getDni());
	    if(!(strlen($usuarioNuevo->getContrasena())<=3) && !$usuarioNuevo->getContrasena()==''){
            $usuarioExistente->setContrasena($usuarioNuevo->getContrasena());
        }
	    $usuarioExistente->setRol($usuarioNuevo->getRol());
	    $usuarioExistente->setFNac($usuarioNuevo->getFNac());

    }


}

// URI-MAPPING for this Rest endpoint
$userRest = new UsuarioRest();
URIDispatcher::getInstance()
    ->map("GET","/usuario/residente", array($userRest,"getResidentes"))
    ->map("GET","/usuario/residente/habitacion", array($userRest,"getResidentesHabitacion"))
    ->map("GET","/usuario/trabajador", array($userRest,"getTrabajadores"))
    ->map("GET","/usuario/$1", array($userRest,"login"))
    ->map("POST","/usuario", array($userRest,"register"))
    ->map("POST","/usuario/manual", array($userRest,"registroManual"))
    ->map("POST","/usuario/residente/$1", array($userRest,"modificarResidente"))
    ->map("POST","/usuario/trabajador/$1", array($userRest,"modificarTrabajador"))
    ->map("DELETE","/usuario/trabajador/$1", array($userRest,"eliminarTrabajador"))
    ->map("DELETE","/usuario/residente/$1", array($userRest,"eliminarResidente"));

