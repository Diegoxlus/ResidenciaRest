<?php


class ConfiguracionMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function getConfiguracion(){
        $stmt = $this->db->prepare("SELECT * FROM configuracion");
        $stmt->execute();
        $resul= $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;

    }

    public function editarConfiguracion(Configuracion $configuracion){
        $stmt = $this->db->prepare("INSERT INTO configuracion (id,hora_comida, hora_cena, limite_hora_comida, limite_hora_cena, registro) VALUES (1,?,?,?,?,?) ON DUPLICATE KEY UPDATE hora_comida = ?,hora_cena = ?, limite_hora_comida =?, limite_hora_cena = ?, registro = ?");
        $resul = $stmt->execute(array($configuracion->getHoraComida(),$configuracion->getHoraCena(),$configuracion->getLimiteHoraComida(),$configuracion->getLimiteHoraCena(),$configuracion->getRegistro(),$configuracion->getHoraComida(),$configuracion->getHoraCena(),$configuracion->getLimiteHoraComida(),$configuracion->getLimiteHoraCena(),$configuracion->getRegistro()));
        return $resul;

    }
}
