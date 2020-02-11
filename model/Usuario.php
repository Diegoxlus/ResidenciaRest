<?php
// file: model/Usuariorio.php

class Usuario implements JsonSerializable {
    private $email;
    private $nombre;
    private $apellidos;
    private $dni;
    private $fNac;
    private $contrasena;
    private $rol;

    public function __construct($email=NULL,$nombre=NULL, $apellidos=NULL,$dni=NULL,$fNac=NULL,$contrasena=NULL,$rol=NULL) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->fNac = $fNac;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param null $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return null
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param null $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return null
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param null $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return null
     */
    public function getFNac()
    {
        return $this->fNac;
    }

    /**
     * @param null $fNac
     */
    public function setFNac($fNac)
    {
        $this->fNac = $fNac;
    }



    /**
     * @return null
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * @param null $contrasena
     */
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    /**
     * @return null
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param null $rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    }



    public function checkIsValid(){
        $errores = array();
        if(strlen($this->nombre)==0){
            $errores["nombre"] = "El nombre no puede ser vacio";
        }
        if(strlen($this->apellidos)==0){
            $errores["apellidos"] = "Los apellidos no pueden ser vacios";
        }
        if(strlen($this->email)==0){
            $errores["email"] = "El email no puede ser vacio";
        }
        if(strlen($this->contrasena)<7){
            $errores["contrasena"] = "La contraseña no puede ser inferior a 7 caracteres";
        }
        print_r($errores);
        if(sizeof($errores)>0){
            throw new ValidationException($errores, "user is not valid");
        }
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }



}
