<?php


class Noticia implements JsonSerializable
{
    private $id;
    private $titulo;
    private $dia;
    private $descripcion;

    /**
     * Noticia constructor.
     * @param $id
     * @param $titulo
     * @param $dia
     * @param $descripcion
     */
    public function __construct($id = NULL, $titulo = NULL, $dia = NULL, $descripcion = NULL)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->dia = $dia;
        $this->descripcion = $descripcion;
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
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param null $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param null $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
