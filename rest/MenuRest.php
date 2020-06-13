<?php
require_once(__DIR__ . "/../model/Menu.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/MenuMapper.php");
require_once(__DIR__ . "/BaseRest.php");

abstract class atributosMenu {
    const DIA = "dia";
    const COMIDA = "comida";
    const CENA = "cena";
    const MODIFICADO = "modificado";

}


class MenuRest extends BaseRest {
    private $menuMapper;

    public function __construct() {
        parent::__construct();

        $this->menuMapper = new MenuMapper();
    }

    public function getMenus(){
        parent::verificarRol([0,1,2,3]);
        $menus = $this->menuMapper->getMenus();
        $menusJsonArray = array();

        foreach($menus as $menu){
            array_push($menusJsonArray,array(
                atributosMenu::DIA => $menu->getDia(),
                atributosMenu::COMIDA => $menu->getComida(),
                atributosMenu::CENA => $menu->getCena(),
                atributosMenu::MODIFICADO => $menu->getModificado()
            ));
        }
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($menusJsonArray));
    }

    public function getMenuDia($dia){
        parent::verificarRol([0,1,2,3]);
        $menu = $this->menuMapper->getMenuDia($dia);
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($menu));

    }

    public function addMenu(){
        parent::verificarRol([2]);
        $data = json_decode($_POST['menu'],true);
        $menu = new Menu($data['_dia'],$data['_comida'],$data['_cena'],false);

        try{

        if($this->menuMapper->getMenuDia($menu->getDia())!=false){
            $this->menuMapper->editarMenu($menu);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            echo(json_encode("Comida añadida correctamente"));
            exit();

        }
        else {
            $this->menuMapper->añadirMenu($menu);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            echo(json_encode("Comida añadida correctamente"));
        }
        }catch (Exception $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al añadir la comida: ".$e->getMessage()));
        }

    }


}
$menuRest = new MenuRest();
URIDispatcher::getInstance()
    ->map("GET","/menu", array($menuRest,"getMenus"))
    ->map("GET","/menu/$1", array($menuRest,"getMenuDia"))
    ->map("POST","/menu", array($menuRest,"addMenu"));

