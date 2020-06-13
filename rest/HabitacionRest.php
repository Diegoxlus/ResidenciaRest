<?php
/**
 * Copyright (c) Tfg de Diego Lusquiños Otero
 */
require_once ("../model/Habitacion.php");
require_once ("../model/HabitacionMapper.php");
require_once("../rest/BaseRest.php");

 abstract class atributosHabitacion {
     const NUMERO = "numero";
     const TIPO = "tipo";
     const RESIDENTE1 = "residente1";
     const RESIDENTE2 = "residente2";
     const DISPONIBLE = "disponible";

}


class HabitacionRest extends BaseRest
{
    private $habitacionMapper;

    /**
     * HabitacionRest constructor.
     * @param $habitacionMapper
     */
    public function __construct()
    {
        parent::__construct();
        $this->habitacionMapper = new HabitacionMapper();
    }

    public function getHabitaciones(){
        parent::verificarRol([0,1]);
        $habitaciones = $this->habitacionMapper->getHabitaciones();
        $habitacionesJsonArray = array();

        foreach($habitaciones as $habitacion){
            array_push($habitacionesJsonArray,array(
                atributosHabitacion::NUMERO => $habitacion->getNumero(),
                atributosHabitacion::TIPO => $habitacion->getTipo(),
                atributosHabitacion::RESIDENTE1 => $habitacion->getResidente1(),
                atributosHabitacion::RESIDENTE2 => $habitacion->getResidente2(),
                atributosHabitacion::DISPONIBLE => $habitacion->getDisponible(),
            ));
        }
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($habitacionesJsonArray));
    }

    public function getHabitacion($numero){
        parent::verificarRol([0,1]);
        $habitacion = $this->habitacionMapper->getHabitacionByNumero($numero);
        $habitacionJson = array();
            array_push($habitacionJson,array(
                atributosHabitacion::NUMERO => $habitacion->getNumero(),
                atributosHabitacion::TIPO => $habitacion->getTipo(),
                atributosHabitacion::RESIDENTE1 => $habitacion->getResidente1(),
                atributosHabitacion::RESIDENTE2 => $habitacion->getResidente2(),
                atributosHabitacion::DISPONIBLE => $habitacion->getDisponible(),
            ));
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($habitacionJson));
    }



    public function registrarHabitacion(){
        parent::verificarRol([0,1]);
        $data = json_decode($_POST['habitacion'],true);
        $habitacion = new Habitacion($data['_numero'],$data['_tipo'],$data['_residente1'],$data['_residente2'],$data['_disponible']);
    if($this->habitacionMapper->existeHabitacion($habitacion->getNumero())==true){
        http_response_code(400);
        header('Content-Type: application/json');
        echo(json_encode("La habitacion número " .$habitacion->getNumero() ." ya existe"));
        exit();
    }
        try {
            $habitacion->verificar();
            $this->habitacionMapper->eliminarResidentesHabitacion($habitacion);
            $this->habitacionMapper->registrarHabitacion($habitacion);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            echo(json_encode("Registro realizado"));

        }catch (ValidationException $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getError()));
        }catch (Exception $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getMessage()));

        }

    }

    public function editarHabitacion($numero){
        parent::verificarRol([0,1]);
        $data = json_decode($_POST['habitacion'],true);
        $habitacion = new Habitacion($numero,$data['_tipo'],$data['_residente1'],$data['_residente2'],$data['_disponible']);
        try {
            $habitacion->verificar();
            $this->habitacionMapper->eliminarResidentesHabitacion($habitacion);
            $this->habitacionMapper->editarHabitacion($habitacion);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            echo(json_encode("Modificación realizada"));

        }catch (ValidationException $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getError()));
        }catch (Exception $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getMessage()));
        }

    }

    public function eliminarResidenteHabitacion($numeroHab,$residente){
        parent::verificarRol([0,1]);
        $resul = $this->habitacionMapper->eliminarResidenteHabitacion($numeroHab,$residente);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo (json_encode("El residente fue eliminado de la habitacion"));
        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al eliminar al residente"));
        }

    }

    public function eliminarHabitacion($numeroHab){
        parent::verificarRol([0,1]);
        $resul = $this->habitacionMapper->eliminarHabitacion($numeroHab);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo (json_encode(true));
        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al eliminar la habitacion"));
        }

    }


}

// URI-MAPPING for this Rest endpoint
$habitacionRest = new HabitacionRest();
URIDispatcher::getInstance()
    ->map("GET","/habitacion", array($habitacionRest,"getHabitaciones"))
    ->map("GET","/habitacion/$1", array($habitacionRest,"getHabitacion"))
    ->map("DELETE","/habitacion/$1", array($habitacionRest,"eliminarHabitacion"))
    ->map("DELETE","/habitacion/$1/$2", array($habitacionRest,"eliminarResidenteHabitacion"))
    ->map("POST","/habitacion", array($habitacionRest,"registrarHabitacion"))
    ->map("POST","/habitacion/$1", array($habitacionRest,"editarHabitacion"));

