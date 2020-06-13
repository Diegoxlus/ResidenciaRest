<?php


class Pago implements JsonSerializable
{
    private $id;
    private $dia;
    private $residente;
    private $correcto;
    private $mes;
    private $extension;
    private $tipo;

    /**
     * Pago constructor.
     * @param $id
     * @param $fecha
     * @param $residente
     * @param $comprobante
     * @param $rutaComprobante
     * @param $tipo
     * @param $realizado
     */
    public function __construct($id = NULL, $dia = NULL, $residente= NULL, $extension= NULL,$tipo=NULL, $mes= NULL, $correcto= NULL)
    {
        $this->id = $id;
        $this->dia = $dia;
        $this->residente = $residente;
        $this->correcto = $correcto;
        $this->mes = $mes;
        $this->tipo = $tipo;
        $this->extension = $extension;
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
    public function getCorrecto()
    {
        return $this->correcto;
    }

    /**
     * @param null $correcto
     */
    public function setCorrecto($correcto)
    {
        $this->correcto = $correcto;
    }




    /**
     * @return null
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param null $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * @return null
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param null $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param null $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
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
