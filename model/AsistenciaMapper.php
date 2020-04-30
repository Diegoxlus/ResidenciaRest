<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class AsistenciaMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function getAsistenciaUsuario($getEmail)
    {
        $diaActual = $hoy = date("y.m.d");
        $stmt = $this->db->prepare("SELECT menu.dia,menu.comida as menu_comida,menu.cena as menu_cena,asistencia.come,asistencia.cena FROM menu LEFT JOIN asistencia ON menu.dia = asistencia.dia AND asistencia.residente=? WHERE menu.dia>= ?");
        $stmt->execute(array($getEmail, $diaActual));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function inscribirseComida($dia, $residente){
        $stmt = $this->db->prepare("INSERT INTO asistencia (residente, dia, come) VALUES (?,?,?) ON DUPLICATE KEY UPDATE come = ?");
        $resul = $stmt->execute(array($residente,$dia,1,1));
        return $resul;

    }

    public function inscribirseCena($dia,$residente) {
        $stmt = $this->db->prepare("INSERT INTO asistencia (residente, dia, cena) VALUES (?,?,?) ON DUPLICATE KEY UPDATE cena = ?");
        $resul = $stmt->execute(array($residente,$dia,1,1));
        return $resul;

    }

    public function desinscribirseComida($dia,$residente){
        $stmt = $this->db->prepare("INSERT INTO asistencia (residente, dia, come) VALUES (?,?,?) ON DUPLICATE KEY UPDATE come = ?");
        $resul = $stmt->execute(array($residente,$dia,0,0));
        return $resul;

    }

    public function desinscribirseCena($dia,$residente){
        $stmt = $this->db->prepare("INSERT INTO asistencia (residente, dia, cena) VALUES (?,?,?) ON DUPLICATE KEY UPDATE cena = ?");
        $resul = $stmt->execute(array($residente,$dia,0,0));
        return $resul;

    }


}
