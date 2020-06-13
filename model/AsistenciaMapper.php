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
        $stmt = $this->db->prepare("INSERT INTO asistencia (residente, dia, come,asiste_cena,asiste_comida) VALUES (?,?,?,0,0) ON DUPLICATE KEY UPDATE come = ?");
        $resul = $stmt->execute(array($residente,$dia,1,1));
        return $resul;

    }

    public function inscribirseCena($dia,$residente) {
        $stmt = $this->db->prepare("INSERT INTO asistencia (residente, dia, cena,asiste_comida,asiste_cena) VALUES (?,?,?,0,0) ON DUPLICATE KEY UPDATE cena = ?");
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

    public function getResidentesInscritosComida($dia){
        $stmt = $this->db->prepare("SELECT asistencia.residente,u.nombre,u.apellidos, asistencia.asiste_comida, asistencia.asiste_cena, asistencia.dia FROM asistencia LEFT JOIN usuario u on asistencia.residente = u.email WHERE asistencia.come=1 AND dia=? AND asiste_comida=0");
        $stmt->execute(array($dia));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getResidentesInscritosDia($dia){
        $stmt = $this->db->prepare("SELECT asistencia.residente,u.nombre,u.apellidos, asistencia.asiste_comida, asistencia.asiste_cena, asistencia.come, asistencia.cena, asistencia.dia FROM asistencia LEFT JOIN usuario u on asistencia.residente = u.email WHERE (asistencia.come=1 OR asiste_cena=1) AND dia=?");
        $stmt->execute(array($dia));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getResidentesInscritosCena($dia){
        $stmt = $this->db->prepare("SELECT asistencia.residente,u.nombre,u.apellidos, asistencia.asiste_comida, asistencia.asiste_cena, asistencia.asiste_cena , asistencia.dia FROM asistencia LEFT JOIN usuario u on asistencia.residente = u.email WHERE asistencia.cena=1 AND dia=? AND asiste_cena=0");
        $stmt->execute(array($dia));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function setAsisteComida($residente,$dia){
        $stmt = $this->db->prepare("UPDATE asistencia SET asiste_comida=1 WHERE residente = ? AND dia = ?");
        $resul = $stmt->execute(array($residente,$dia));
        return $resul;

    }

    public function setNoAsisteComida($residente,$dia){
        $stmt = $this->db->prepare("UPDATE asistencia SET asiste_comida=0 WHERE residente = ? AND dia = ?");
        $resul = $stmt->execute(array($residente,$dia));
        return $resul;

    }

    public function setAsisteCena($residente,$dia){
        $stmt = $this->db->prepare("UPDATE asistencia SET asiste_cena=1 WHERE residente = ? AND dia = ?");
        $resul = $stmt->execute(array($residente,$dia));
        return $resul;
    }

    public function setNoAsisteCena($residente,$dia){
        $stmt = $this->db->prepare("UPDATE asistencia SET asiste_cena=0 WHERE residente = ? AND dia = ?");
        $resul = $stmt->execute(array($residente,$dia));
        return $resul;
    }


}
