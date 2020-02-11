<?php
require_once(__DIR__ ."/../core/PDOConnection.php");
require_once (__DIR__."/../model/Menu.php");


class MenuMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function getMenus() {
        $stmt = $this->db->prepare("SELECT * FROM menu ORDER BY dia ASC");
        $stmt->execute();
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $menus = array();
        foreach ($resul as $menu){
            array_push($menus,new Menu($menu["dia"],$menu["comida"],$menu["cena"],$menu["modificado"]));

        }
        return $menus;
    }

    public function añadirMenu(Menu $menu)
    {
        $dia = $menu->getDia();
        $stmt = $this->db->prepare("INSERT INTO menu values (?,?,?,?)");
        $stmt->execute(array($dia,$menu->getComida(),$menu->getCena(),false));
    }

    public function editarMenu(Menu $menu){
        $dia = $menu->getDia();
        $stmt = $this->db->prepare("UPDATE menu set comida=?, cena=?, modificado=? where id=?");
        $stmt->execute(array($menu->getComida(),$menu->getCena(),true,$dia));
    }

    public function eliminarMenu(Menu $menu){
        $dia = $menu->getDia();
        $stmt = $this->db->prepare("DELETE from menu WHERE dia=?");
        $stmt->execute(array($dia));
    }


}
