<?php
require_once(__DIR__ . "/../model/Parte.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/ParteMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class ParteRest extends BaseRest {
    private $parteMapper;

    public function __construct() {
        parent::__construct();

        $this->parteMapper = new ParteMapper();
    }

    function addParte(){
        parent::verificarRol([0,1]);
        $data = json_decode($_POST['parte'],true);
        $parte = new Parte('',$data['_residente'],$data['_gravedad'],$data['_motivo']);
         $resul = $this->parteMapper->addParte($parte);
        if($resul == 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');

        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al crear el parte"));
        }

    }

    function editarParte(){
        parent::verificarRol([0,1]);

        $data = json_decode($_POST['parte'],true);
        $parte = new Parte($data['_id'],$data['_residente'],$data['_gravedad'],$data['_motivo']);
        $resul = $this->parteMapper->editarParte($parte);
        if($resul == 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');

        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al editar el parte"));
        }

    }

    function getPartes(){
        parent::verificarRol([0,1]);

            $partesArray = $this->parteMapper->getPartes();
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode($partesArray));

    }

    function eliminarParte($id){
        parent::verificarRol([0,1]);

        $resul  = $parte = $this->parteMapper->eliminarParte($id);
            if($resul == 1){
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                header('Content-Type: application/json');
                echo(json_encode(true));
            }else{
                http_response_code(400);
                header('Content-Type: application/json');
                echo(json_encode("Error al eliminar el parte"));
            }
    }

}

$parteRest = new ParteRest();
URIDispatcher::getInstance()
    ->map("POST","/parte", array($parteRest,"addParte"))
    ->map("POST","/parte/editar", array($parteRest,"editarParte"))
    ->map("GET","/parte", array($parteRest,"getPartes"))
    ->map("DELETE","/parte/eliminar/$1", array($parteRest,"eliminarParte"));
