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
        //$currentLogged = parent::authenticateUser();
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

    public function addMenu($data){

        $menu = new Menu($data->dia,$data->comida,$data->cena,false);
        try{
            $this->menuMapper->añadirMenu($menu);
            header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
            header("Location: " . $_SERVER['REQUEST_URI'] . "/" . $data->dia);
        }catch (Exception $e){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode($e->getMessage()));
        }

    }

}
$menuRest = new MenuRest();
URIDispatcher::getInstance()
    ->map("GET","/menu", array($menuRest,"getMenus"))
    ->map("POST","/menu", array($menuRest,"addMenu"));

