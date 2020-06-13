<?php

require_once(__DIR__ ."/../core/PDOConnection.php");


class PermanenciaMapper
{
    private $db;
    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function addPermanencia(Permanencia $permanencia ){
        $stmt = $this->db->prepare("INSERT INTO permanencia VALUES (?,?,?)");
        $resul = $stmt->execute(array($permanencia->getId(),$permanencia->getResidente(),$permanencia->getDia()));
        return $resul;
    }

    public function deletePermanencia(Permanencia $permanencia ){
        $stmt = $this->db->prepare("DELETE from permanencia WHERE id = ? ");
        $resul = $stmt->execute(array($permanencia->getId()));
        return $resul;
    }

    public function getPermanencias($dia){
        $stmt = $this->db->prepare("SELECT u.nombre,u.apellidos, h.numero from permanencia LEFT JOIN usuario u on permanencia.residente = u.email LEFT JOIN habitacion h on u.email = h.residente1 WHERE dia = ?");
        $stmt->execute(array($dia));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getPermanenciasPropias($residente){
        $stmt = $this->db->prepare("SELECT * from permanencia WHERE residente = ?");
        $stmt->execute(array($residente));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getPermanenciaById($id){
        $stmt = $this->db->prepare("SELECT * from permanencia WHERE id = ?");
        $stmt->execute(array($id));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function comprobarPermanencia($residente,$dia){
        $stmt = $this->db->prepare("SELECT COUNT(*) from permanencia WHERE residente = ? AND dia=?");
        $stmt->execute(array($residente,$dia));
        $resul = $stmt->fetch();
        return $resul ['COUNT(*)'];
    }

    public function eliminarPermanencia($id)
    {
        $stmt = $this->db->prepare("DELETE from permanencia WHERE id = ?");
        $resul = $stmt->execute(array($id));
        return $resul;
    }

}
