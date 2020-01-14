<?php


class Asistencia implements JsonSerializable
{
    private $dia;
    private $come;
    private $cena;
    private $residente;
    private $asiste_comida;
    private $asiste_cena;

    /**
     * Asistencia constructor.
     * @param $dia
     * @param $come
     * @param $cena
     * @param $residente
     * @param $asiste_comida
     * @param $asiste_cena
     */
    public function __construct($dia = NULL, $come= NULL, $cena= NULL, $residente= NULL, $asiste_comida= NULL, $asiste_cena= NULL)
    {
        $this->dia = $dia;
        $this->come = $come;
        $this->cena = $cena;
        $this->residente = $residente;
        $this->asiste_comida = $asiste_comida;
        $this->asiste_cena = $asiste_cena;
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
    public function getCome()
    {
        return $this->come;
    }

    /**
     * @param null $come
     */
    public function setCome($come)
    {
        $this->come = $come;
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
    public function getAsisteComida()
    {
        return $this->asiste_comida;
    }

    /**
     * @param null $asiste_comida
     */
    public function setAsisteComida($asiste_comida)
    {
        $this->asiste_comida = $asiste_comida;
    }

    /**
     * @return null
     */
    public function getAsisteCena()
    {
        return $this->asiste_cena;
    }

    /**
     * @param null $asiste_cena
     */
    public function setAsisteCena($asiste_cena)
    {
        $this->asiste_cena = $asiste_cena;
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
