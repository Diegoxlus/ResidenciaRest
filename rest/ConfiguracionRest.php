<?php
require_once(__DIR__ . "/../model/Configuracion.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/ConfiguracionMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class ConfiguracionRest extends BaseRest {
    private $configuracionMapper;

    public function __construct() {
        parent::__construct();

        $this->configuracionMapper = new ConfiguracionMapper();
    }

    public function getConfiguracion(){
        $currentUser = parent::verificarRol([parent::DIRECTORA,parent::SECRETARIA]);
        $result = $this->configuracionMapper->getConfiguracion();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($result));

    }

    public function editarConfiguracion(){
        $currentUser = parent::verificarRol([parent::DIRECTORA,parent::SECRETARIA]);
        $data = json_decode($_POST['configuracion'],true);
        $configuracion = new Configuracion(1,$data["_hora_comida"],$data["_hora_cena"],$data["_limite_hora_comida"],$data["_limite_hora_cena"]);
        $result = $this->configuracionMapper->editarConfiguracion($configuracion);
        if($result == true){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo (json_encode($result));
        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al eliminar la habitacion"));
        }

    }

}

$configuracionRest = new ConfiguracionRest();
URIDispatcher::getInstance()
    ->map("GET","/configuracion", array($configuracionRest,"getConfiguracion"))
    ->map("POST","/configuracion", array($configuracionRest,"editarConfiguracion"));
