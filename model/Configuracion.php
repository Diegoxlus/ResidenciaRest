<?php


class Configuracion
{
    private $id;
    private $hora_comida;
    private $hora_cena;
    private $limite_hora_comida;
    private $limite_hora_cena;

    /**
     * Configuracion constructor.
     * @param $id
     * @param $hora_comida
     * @param $hora_cena
     * @param $limite_hora_comida
     * @param $limite_hora_cena
     */
    public function __construct($id = NULL, $hora_comida = NULL, $hora_cena = NULL, $limite_hora_comida = NULL, $limite_hora_cena = NULL)
    {
        $this->id = $id;
        $this->hora_comida = $hora_comida;
        $this->hora_cena = $hora_cena;
        $this->limite_hora_comida = $limite_hora_comida;
        $this->limite_hora_cena = $limite_hora_cena;
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
    public function getHoraComida()
    {
        return $this->hora_comida;
    }

    /**
     * @param mixed $hora_comida
     */
    public function setHoraComida($hora_comida)
    {
        $this->hora_comida = $hora_comida;
    }

    /**
     * @return mixed
     */
    public function getHoraCena()
    {
        return $this->hora_cena;
    }

    /**
     * @param mixed $hora_cena
     */
    public function setHoraCena($hora_cena)
    {
        $this->hora_cena = $hora_cena;
    }

    /**
     * @return mixed
     */
    public function getLimiteHoraComida()
    {
        return $this->limite_hora_comida;
    }

    /**
     * @param mixed $limite_hora_comida
     */
    public function setLimiteHoraComida($limite_hora_comida)
    {
        $this->limite_hora_comida = $limite_hora_comida;
    }

    /**
     * @return mixed
     */
    public function getLimiteHoraCena()
    {
        return $this->limite_hora_cena;
    }

    /**
     * @param mixed $limite_hora_cena
     */
    public function setLimiteHoraCena($limite_hora_cena)
    {
        $this->limite_hora_cena = $limite_hora_cena;
    }



}

