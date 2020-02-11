<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UserMapper {

private $db;
public function __construct() {
$this->db = PDOConnection::getInstance();
}

    public function registrarUsuario(Usuario $usuario)
    {
        $stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?,?,?,?)");
        $stmt->execute(array($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellidos(), $usuario->getDni(), $usuario->getFNac(), $usuario->getContrasena(), $usuario->getRol()));
    }

    public function registroManual(Usuario $usuario)
    {
        $stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?,?,?,?)");
        $stmt->execute(array($usuario->getEmail(), $usuario->getNombre(), $usuario->getApellidos(), null, null, $usuario->getContrasena(), $usuario->getRol()));
    }


    public function emailExists($email) {
$stmt = $this->db->prepare("SELECT count(email) FROM usuario where email=?");
$stmt->execute(array($email));
if ($stmt->fetchColumn() > 0) {
return true;
}
}

    public function login($username, $passwd)
    {
    $stmt = $this->db->prepare("SELECT count(nombre) FROM usuario where email=? and contraseña=?");
    $stmt->execute(array($username, $passwd));
    if ($stmt->fetchColumn() > 0) {
        return true;
    }
}

    public function getUsiarioByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuario where email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function cambiarDatos(Usuario $usuario)
    {
        $stmt = $this->db->prepare("UPDATE usuario set contraseña=?, where email=?");
        $stmt->execute(array($usuario->getContrasena(), $usuario->getEmail()));
    }

    public function eliminarUsuario(Usuario $usuario)
    {
        $stmt = $this->db->prepare("DELETE from usuario WHERE email=?");
        if ($stmt->execute(array($usuario->getEmail()))) {
            return 1;
        } else return 0;
    }

    public function getResidentes()
    {
        $stmt = $this->db->prepare("SELECT email,nombre,apellidos,dni,f_nac,rol from usuario WHERE rol=3");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;

    }

    public function getTrabajadores()
    {
        $stmt = $this->db->prepare("SELECT email,nombre,apellidos,dni,f_nac,rol from usuario WHERE rol!=3");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;

    }

    public function getResidentesHabitacion()
    {
        $stmt = $this->db->prepare("SELECT usuario.email,usuario.nombre,usuario.apellidos,usuario.dni,usuario.f_nac,usuario.rol,habitacion.numero FROM usuario LEFT JOIN habitacion ON usuario.email=habitacion.residente1 WHERE usuario.rol=3");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }


}
