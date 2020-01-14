<?php


class Menu implements JsonSerializable
{
    private $dia;
    private $comida;
    private $cena;
    private $modificado;

    /**
     * Menu constructor.
     * @param $dia
     * @param $comida
     * @param $cena
     * @param $modificado
     */
    public function __construct($dia = NULL, $comida = NULL, $cena = NULL, $modificado = NULL)
    {
        $this->dia = $dia;
        $this->comida = $comida;
        $this->cena = $cena;
        $this->modificado = $modificado;
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
    public function getComida()
    {
        return $this->comida;
    }

    /**
     * @param null $comida
     */
    public function setComida($comida)
    {
        $this->comida = $comida;
    }

    /**
     * @return null
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * @param null $cena
     */
    public function setCena($cena)
    {
        $this->cena = $cena;
    }

    /**
     * @return null
     */
    public function getModificado()
    {
        return $this->modificado;
    }

    /**
     * @param null $modificado
     */
    public function setModificado($modificado)
    {
        $this->modificado = $modificado;
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
