<?php


class Pago implements JsonSerializable
{
    private $id;
    private $fecha;
    private $residente;
    private $comprobante;
    private $rutaComprobante;
    private $tipo;
    private $realizado;

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
    public function __construct($id = NULL, $fecha = NULL, $residente= NULL, $comprobante= NULL, $rutaComprobante= NULL, $tipo= NULL, $realizado= NULL)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->residente = $residente;
        $this->comprobante = $comprobante;
        $this->rutaComprobante = $rutaComprobante;
        $this->tipo = $tipo;
        $this->realizado = $realizado;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param null $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
    public function getComprobante()
    {
        return $this->comprobante;
    }

    /**
     * @param null $comprobante
     */
    public function setComprobante($comprobante)
    {
        $this->comprobante = $comprobante;
    }

    /**
     * @return null
     */
    public function getRutaComprobante()
    {
        return $this->rutaComprobante;
    }

    /**
     * @param null $rutaComprobante
     */
    public function setRutaComprobante($rutaComprobante)
    {
        $this->rutaComprobante = $rutaComprobante;
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
     * @return null
     */
    public function getRealizado()
    {
        return $this->realizado;
    }

    /**
     * @param null $realizado
     */
    public function setRealizado($realizado)
    {
        $this->realizado = $realizado;
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
