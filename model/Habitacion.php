<?php
/**
 * Copyright (c) Tfg de Diego Lusquiños Otero
 */

class Habitacion
{
    private $numero;
    private $tipo;
    private $residente1;
    private $residente2;
    private $disponible;

    /**
     * habitacion constructor.
     * @param $numero
     * @param $tipo
     * @param $residente1
     * @param $residente2
     * @param $disponible
     */
    public function __construct($numero=NULL, $tipo=NULL, $residente1= NULL, $residente2=NULL, $disponible=NULL)
    {
        $this->numero = $numero;
        $this->tipo = $tipo;
        $this->residente1 = $residente1;
        $this->residente2 = $residente2;
        $this->disponible = $disponible;
    }

    /**
     * @return null
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param null $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
    public function getResidente1()
    {
        return $this->residente1;
    }

    /**
     * @param null $residente1
     */
    public function setResidente1($residente1)
    {
        $this->residente1 = $residente1;
    }

    /**
     * @return null
     */
    public function getResidente2()
    {
        return $this->residente2;
    }

    /**
     * @param null $residente2
     */
    public function setResidente2($residente2)
    {
        $this->residente2 = $residente2;
    }

    /**
     * @return null
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * @param null $disponible
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    }





}
