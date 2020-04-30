<?php
require_once(__DIR__ ."/../core/PDOConnection.php");


class ParteMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function addParte(Parte $parte)
    {
        $stmt = $this->db->prepare("INSERT INTO parte VALUES ('',?,?,?)");
        $resul = $stmt->execute(array($parte->getResidente(),$parte->getGravedad(),$parte->getMotivo()));
        return $resul;
    }

    public function getPartes()
    {
        $stmt = $this->db->prepare("SELECT parte.id, parte.residente, parte.gravedad , parte.motivo , usuario.nombre, usuario.apellidos  FROM parte LEFT JOIN usuario ON usuario.email= parte.residente ");
        $stmt->execute(array());
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function editarParte(Parte $parte)
    {
        $stmt = $this->db->prepare("UPDATE parte SET gravedad = ? , motivo=? WHERE parte.id = ?");
        $resul = $stmt->execute(array($parte->getGravedad(),$parte->getMotivo(),$parte->getId()));
        return $resul;
    }

    public function eliminarParte($id)
    {
        $stmt = $this->db->prepare("DELETE from parte WHERE id = ?");
        $resul = $stmt->execute(array($id));
        return $resul;
    }

}
