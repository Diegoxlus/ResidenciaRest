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
        $currentLogged = parent::usuarioAutenticado();
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
        $data = json_decode($_POST['habitacion'],true);
        //$currentLogged = parent::usuarioAutenticado();
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


}

// URI-MAPPING for this Rest endpoint
$habitacionRest = new HabitacionRest();
URIDispatcher::getInstance()
    ->map("GET","/habitacion", array($habitacionRest,"getHabitaciones"))
    ->map("GET","/habitacion/$1", array($habitacionRest,"getHabitacion"))
    ->map("POST","/habitacion", array($habitacionRest,"registrarHabitacion"));
