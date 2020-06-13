<?php
require_once(__DIR__ ."/../core/PDOConnection.php");


class PagoMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function addPago($id,$residente,$extension,$tipo,$mes)
    {
        $hoy = date("Y-m-d");
        $this->existePago($residente,$mes);
        $stmt = $this->db->prepare("INSERT INTO pago VALUES (?,?,?,?,?,?,0)");
        $resul = $stmt->execute(array($id,$residente,$hoy,$extension,$tipo,$mes));
        return $resul;


    }

    public function existePago($residente, $mes){
        $stmt = $this->db->prepare("SELECT id,extension FROM pago WHERE residente= ? AND mes = ? AND correcto = 0 ");
        $stmt->execute(array($residente,$mes));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $resul['id'];
        $extension = $resul['extension'];

        if($resul ){
            $stmt = $this->db->prepare("DELETE FROM pago WHERE residente= ? AND mes = ? AND correcto = 0 ");
            $stmt->execute(array($residente,$mes));
            unlink("../pagos/".$id.".".$extension);
        }

    }

    public function getPagosPropios($residente)
    {
        $stmt = $this->db->prepare("SELECT * FROM pago WHERE residente= ?");
        $stmt->execute(array($residente));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function getPago($idPago)
    {

        $stmt = $this->db->prepare("SELECT * FROM pago WHERE id= ?");
        $stmt->execute(array($idPago));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Pago($resul['id'],'',$resul['residente'],$resul['extension'],$resul['tipo']);
    }

    public function getPagoByID($idPago)
    {
        $stmt = $this->db->prepare("SELECT * FROM pago WHERE id= ?");
        $stmt->execute(array($idPago));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Pago($resul['id'],'','',$resul['extension'],$resul['tipo']);
    }

    public function getPagos($mes, $opcion)
    {
        $stmt = $this->db->prepare("SELECT pago.id,pago.correcto,pago.mes,pago.residente,pago.extension,pago.tipo,u.nombre,u.apellidos FROM pago LEFT JOIN usuario u on pago.residente = u.email WHERE mes= ? AND correcto= ? ORDER BY u.nombre");
        $stmt->execute(array($mes,$opcion));
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function rechazarPago($id)
    {
        $stmt = $this->db->prepare("UPDATE pago SET correcto = 2 WHERE id = ?");
        $resul = $stmt->execute(array($id));
        return $resul;
    }

    public function eliminarPago($id)
    {
        $pago = $this->getPagoByID($id);
        unlink("../pagos/".$pago->getId().".".$pago->getExtension());
        $stmt = $this->db->prepare("DELETE from pago WHERE pago.id = ?");
        $resul = $stmt->execute(array($id));

        return $resul;

    }

    public function verificarPago($id)
    {
        $stmt = $this->db->prepare("UPDATE pago SET correcto = 1 WHERE id = ?");
        $resul = $stmt->execute(array($id));
        return $resul;
    }

}
