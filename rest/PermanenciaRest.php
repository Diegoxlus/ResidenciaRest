<?php
require_once(__DIR__ . "/../model/PermanenciaMapper.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/Permanencia.php");
require_once(__DIR__ . "/BaseRest.php");

class PermanenciaRest extends BaseRest {

	private $permanenciaMapper;

	public function __construct() {
    parent::__construct();

    $this->permanenciaMapper = new PermanenciaMapper();
}

 public function addPermanencia(){
     $residente = parent::verificarRol([3]);
     $id = uniqid();
     $data = json_decode($_POST['permanencia'],true);
     $permanencia = new Permanencia($id,$residente->getEmail(),$data['_dia']);
     if($this->permanenciaMapper->comprobarPermanencia($permanencia->getResidente(),$permanencia->getDia())==1){
         http_response_code(400);
         header('Content-Type: application/json');
         echo(json_encode("Ya estás anotado para este día"));
         exit();
     }
     $resul = $this->permanenciaMapper->addPermanencia($permanencia);
     if($resul == 1){
         header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
         header('Content-Type: application/json');

     }
     else{
         http_response_code(400);
         header('Content-Type: application/json');
         echo(json_encode("Error al anotar la permanencia"));
     }
 }

    function eliminarPermanencia($id){
        $residente = parent::verificarRol([3]);
        if($this->permanenciaMapper->getPermanenciaById($id)['residente']!=$residente->getEmail()){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Esta permanencia no es tuya."));
            exit();
        }
        $resul = $this->permanenciaMapper->eliminarPermanencia($id);
        if($resul == 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode(true));
        }else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al eliminar la permanencia"));
        }
    }

    function getPermanenciasHoy(){
        parent::verificarRol([0,1,4]);
        $dia = date("Y-m-d");
	    $permanencias = $this->permanenciaMapper->getPermanencias($dia);
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($permanencias));
    }

    function getPermanenciasPropias(){
        $residente = parent::verificarRol([3]);
        $permanencias = $this->permanenciaMapper->getPermanenciasPropias($residente->getEmail());
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($permanencias));
    }





}

// URI-MAPPING for this Rest endpoint
$permanenciaRest = new PermanenciaRest();
URIDispatcher::getInstance()
    ->map("GET","/permanencia/hoy", array($permanenciaRest,"getPermanenciasHoy"))
    ->map("GET","/permanencia", array($permanenciaRest,"getPermanenciasPropias"))
    ->map("POST","/permanencia", array($permanenciaRest,"addPermanencia"))
    ->map("DELETE","/permanencia/$1", array($permanenciaRest,"eliminarPermanencia"));

