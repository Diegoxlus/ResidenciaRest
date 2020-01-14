<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class UserMapper {

private $db;
public function __construct() {
$this->db = PDOConnection::getInstance();
}

public function save($user) {
    $stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?,?,?)");
    $stmt->execute(array($user->getEmail(), $user->getNombre(), $user->getApellidos(),$user->getDni(),$user->getContrasena(),$user->getRol()));
}

public function emailExists($email) {
$stmt = $this->db->prepare("SELECT count(email) FROM usuario where email=?");
$stmt->execute(array($email));
if ($stmt->fetchColumn() > 0) {
return true;
}
}

public function isValidUser($username, $passwd) {
    $stmt = $this->db->prepare("SELECT count(nombre) FROM usuario where email=? and contraseña=?");
    $stmt->execute(array($username, $passwd));
    if ($stmt->fetchColumn() > 0) {
        return true;
    }
}

    public function getUserByName($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuario where email=?");
        $stmt->execute(array($email));
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resul;
    }


}
