<?php
require_once(__DIR__ . "/../model/Noticia.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/NoticiaMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class NoticiaRest extends BaseRest {
    private $noticiaMapper;

    public function __construct() {
        parent::__construct();

        $this->noticiaMapper = new NoticiaMapper();
    }

    function addNoticia(){
        parent::verificarRol([0,1]);
        $hoy = date("Y-m-d");
        $data = json_decode($_POST['noticia'],true);
        $noticia = new Noticia('',$data['_titulo'],$hoy,$data['_descripcion']);
        $resul = $this->noticiaMapper->addNoticia($noticia);
        if($resul == 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');

        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al crear la noticia"));
        }

    }

    function editarNoticia(){
        parent::verificarRol([0,1]);
        $hoy = date("Y-m-d");

        $data = json_decode($_POST['noticia'],true);
        $noticia = new Noticia($data['_id'],$data['_titulo'],$hoy,$data['_descripcion']);
        $resul = $this->noticiaMapper->editarNoticia($noticia);
        if($resul == 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');

        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al editar la noticia"));
        }

    }

    function getNoticias(){

        parent::verificarRol([0,1,3]);
        $noticiasArray = $this->noticiaMapper->getNoticias();
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($noticiasArray));

    }

    function eliminarNoticia($id){
        parent::verificarRol([0,1]);
        $resul  = $noticia = $this->noticiaMapper->eliminarNoticia($id);
        if($resul == 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode(true));
        }else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al eliminar la noticia"));
        }
    }

}

$noticiaRest = new NoticiaRest();
URIDispatcher::getInstance()
    ->map("POST","/noticia", array($noticiaRest,"addNoticia"))
    ->map("POST","/noticia/editar", array($noticiaRest,"editarNoticia"))
    ->map("GET","/noticia", array($noticiaRest,"getNoticias"))
    ->map("DELETE","/noticia/eliminar/$1", array($noticiaRest,"eliminarNoticia"));
