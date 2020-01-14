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
        //$currentLogged = parent::authenticateUser();
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
        $currentLogged = parent::authenticateUser();
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

    public function registrarHabitacion($data){
        $currentLogged = parent::authenticateUser();
        $habitacion = new Habitacion($data->numero,$data->tipo,$data->residente1,$data->residente2,$data->disponible);
        //$habitacion->comprobarDatos();
        try {
            $this->habitacionMapper->registrarHabitacion($habitacion);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            header("Location: " . $_SERVER['REQUEST_URI'] . "/" . $data->numero);
        }catch (Exception $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getMessage()));
        }
    }


}

// URI-MAPPING for this Rest endpoint
$habitacionRest = new HabitacionRest();
URIDispatcher::getInstance()
    ->map("GET","/habitacion", array($habitacionRest,"getHabitaciones"))
    ->map("GET","/habitacion/$1", array($habitacionRest,"getHabitacion"))
    ->map("POST","/habitacion", array($habitacionRest,"registrarHabitacion"));
