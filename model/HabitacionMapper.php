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
    public function existeHabitacion($numero) : bool {
        $stmt = $this->db->prepare("SELECT count(*) FROM habitacion where numero=?");
        $stmt->execute(array($numero));
        if ($stmt->fetchColumn() > 0) {
            return true;
        }
        else return false;
    }

    public function registrarHabitacion(Habitacion $habitacion){
        if($habitacion->getResidente1()==$habitacion->getResidente2()){
            $habitacion->setResidente2(NULL);
        }

        $stmt = $this->db->prepare("INSERT INTO habitacion values (?,?,?,?,?)");
        $stmt->execute(array($habitacion->getNumero(), $habitacion->getTipo(), $habitacion->getResidente1(),$habitacion->getResidente2(),$habitacion->getDisponible()));
    }
    public function eliminarResidentesHabitacion(Habitacion $habitacion)
    {
        $email1 = $habitacion->getResidente1();
        $email2 = $habitacion->getResidente2();
        if ($email1 != null || $email2!=null) {
            $stmt = $this->db->prepare("SELECT numero FROM habitacion WHERE residente1=? OR residente2=?");

            if($stmt->execute(array($email1, $email2))==1) {
                $numero = $stmt->fetch(PDO::FETCH_ASSOC)['numero'];
                $stmt = $this->db->prepare("UPDATE habitacion SET residente1=NULL,residente2=NULL WHERE numero= ?");
                $stmt->execute(array($numero));

            }
        }

    }

    public function eliminarResidenteHabitacion($numeroHab, $residente)
    {
        $stmt1 = $this->db->prepare("UPDATE habitacion SET residente1 = null WHERE residente1 = ? AND numero= ?");
        $stmt2 = $this->db->prepare("UPDATE habitacion SET residente2 = null WHERE residente2 = ? AND numero= ?");
        $resul1= $stmt1->execute(array($residente,$numeroHab));
        $resul2= $stmt2->execute(array($residente,$numeroHab));

        return $resul1 && $resul2 == 1;

    }

    public function editarHabitacion(Habitacion $habitacion)
    {

        if(!$habitacion->getDisponible()){
            $habitacion->setDisponible(0);
        }
        $stmt = $this->db->prepare("UPDATE habitacion set tipo=?, residente1=?,residente2=?,disponible=? where numero=?");
        $resul1= $stmt->execute(array($habitacion->getTipo(),$habitacion->getResidente1(),$habitacion->getResidente2(),$habitacion->getDisponible(),$habitacion->getNumero()));
        return $resul1;

    }

    public function eliminarHabitacion($numeroHabitacion)
    {
        $stmt = $this->db->prepare("DELETE from habitacion WHERE numero = ?");
        if ($stmt->execute(array($numeroHabitacion))) {
            return 1;
        } else return 0;

    }
}


