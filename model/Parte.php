<?php


class Parte implements JsonSerializable
{
    private $id;
    private $dia;
    private $emisor; // Personal de la residencia que pone el parte(ej:Secretaria)
    private $residente;
    private $gravedad;
    private $motivo;

    /**
     * Parte constructor.
     * @param $id
     * @param $dia
     * @param $emisor
     * @param $residente
     * @param $gravedad
     * @param $motivo
     */
    public function __construct($id = NULL, $dia = NULL, $emisor= NULL, $residente = NULL, $gravedad = NULL, $motivo = NULL)
    {
        $this->id = $id;
        $this->dia = $dia;
        $this->emisor = $emisor;
        $this->residente = $residente;
        $this->gravedad = $gravedad;
        $this->motivo = $motivo;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param null $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @return null
     */
    public function getEmisor()
    {
        return $this->emisor;
    }

    /**
     * @param null $emisor
     */
    public function setEmisor($emisor)
    {
        $this->emisor = $emisor;
    }

    /**
     * @return null
     */
    public function getResidente()
    {
        return $this->residente;
    }

    /**
     * @param null $residente
     */
    public function setResidente($residente)
    {
        $this->residente = $residente;
    }

    /**
     * @return null
     */
    public function getGravedad()
    {
        return $this->gravedad;
    }

    /**
     * @param null $gravedad
     */
    public function setGravedad($gravedad)
    {
        $this->gravedad = $gravedad;
    }

    /**
     * @return null
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param null $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
