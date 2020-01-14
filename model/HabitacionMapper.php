<?php
/**
 * Copyright (c) Tfg de Diego Lusquiños Otero
 */

require_once(__DIR__ ."/../core/PDOConnection.php");

class HabitacionMapper
{

    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function getHabitaciones() {
        $stmt = $this->db->prepare("SELECT * FROM habitacion ORDER BY numero ASC");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $habitaciones = array();
        foreach ($resul as $habitacion){
            array_push($habitaciones,new Habitacion($habitacion["numero"],$habitacion["tipo"],$habitacion["residente1"],$habitacion["residente2"],$habitacion["disponible"]));

        }
        return $habitaciones;
    }

    public function getHabitacionByNumero($numero) {
        $stmt = $this->db->prepare("SELECT * FROM habitacion WHERE numero= ?");
        $stmt->execute(array($numero));
        $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Habitacion($habitacion["numero"],$habitacion["tipo"],$habitacion["residente1"],$habitacion["residente2"],$habitacion["disponible"]);
    }

    public function registrarHabitacion($habitacion){
        $stmt = $this->db->prepare("INSERT INTO habitacion values (?,?,?,?,?)");
        $stmt->execute(array($habitacion->getNumero(), $habitacion->getTipo(), $habitacion->getResidente1(),$habitacion->getResidente2(),$habitacion->getDisponible()));
    }

}
