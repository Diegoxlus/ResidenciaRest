<?php


class Permanencia
{
    private $id;
    private $residente;
    private $dia;

    /**
     * Permanencia constructor.
     * @param $id
     * @param $residente
     * @param $dia
     */
    public function __construct($id = NULL, $residente = NULL, $dia = NULL)
    {
        $this->id = $id;
        $this->residente = $residente;
        $this->dia = $dia;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getResidente()
    {
        return $this->residente;
    }

    /**
     * @param mixed $residente
     */
    public function setResidente($residente)
    {
        $this->residente = $residente;
    }

    /**
     * @return mixed
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param mixed $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }




}
