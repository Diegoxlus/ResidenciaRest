<?php
require_once(__DIR__ . "/../model/Pago.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/PagoMapper.php");
require_once(__DIR__ . "/BaseRest.php");



class PagoRest extends BaseRest {
    private $pagoMapper;

    public function __construct() {
        parent::__construct();

        $this->pagoMapper = new PagoMapper();
    }



public function addPago(){
    parent::verificarRol([3]);
    $this->addFile();

}


    public function addFile(){
        $id = uniqid();
        $residente = $_POST['residente'];
        $mes = $_POST['mes'];
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $tipo = $_FILES['archivo']['type'];
        $allowedfileExtensions = array('jpg', 'png', 'zip','doc','pdf','rar');



        if (in_array($fileExtension, $allowedfileExtensions)) {
            if(move_uploaded_file($fileTmpPath,"../pagos/$id".'.'.$fileExtension))
            {
                $result = $this->pagoMapper->addPago($id,$residente,$fileExtension,$tipo,$mes);
                if($result == 1){
                    header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                    header('Content-Type: application/json');
                }
                else{
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo(json_encode("Error al subir el pago"));
                }
            }
            else
            {

                http_response_code(400);
                header('Content-Type: application/json');
                echo(json_encode("Error en el servidor"));

            }

        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al recibir el pago, formatos admitidos: jpg, png, zip, doc, pdf, rar"));
        }
    }

    function getPagosPropios($residente){
        parent::verificarRol([3]);
        $pagos = $this->pagoMapper->getPagosPropios($residente);
        if($pagos){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode($pagos));
        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error, comprueba que hay pagos realizados"));
        }

    }

    public function descargarPago($idPago){
        $currentUser = parent::verificarRol([0,1,3]);
        $pago = $this->pagoMapper->getPago($idPago);
        if($currentUser->getRol()==3){
            if($currentUser->getEmail()!= $pago->getResidente()){
                http_response_code(400);
                header('Content-Type: application/json');
                echo(json_encode("No eres el residente que realizó este pago "));
                exit();
            }
        }

            if($pago==NULL){
                header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
                echo("Pago no encontrado");
                return;
            }
            $fileName = $pago->getId();
            $fileType = $pago->getTipo();
            $extension = $pago->getExtension();
            $filePath = "../pagos/".$fileName.".".$extension;
            if(!empty($fileName) && file_exists($filePath)){
                // Define headers
                header('Content-Disposition: attachment; filename="'.$fileName.'"');
                header("Content-Type: ".$fileType);
                header("Content-Description:File-Transfer");
                readfile($filePath);
                exit;
            }else{
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                echo("Archivo".$pago->getId()." no encontrado");
                return;
            }
    }

    public function getPagos($mes,$opcion){
        parent::verificarRol([0,1]);
        $pagos = $this->pagoMapper->getPagos($mes,$opcion);
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($pagos));
    }

    public function verificarPago($id){
        parent::verificarRol([0,1]);

        $resul = $this->pagoMapper->verificarPago($id);
        if($resul== 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode(true));
        }
        else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al verificar el pago"));
            exit();
        }
    }

    public function eliminarPago($id){
        parent::verificarRol([0,1]);

        $resul = $this->pagoMapper->eliminarPago($id);
        if($resul== 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode(true));
        }
        else{
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Pago no encontrado");
        }
    }

    public function rechazarPago($id){
        parent::verificarRol([0,1]);

        $resul = $this->pagoMapper->rechazarPago($id);
        if($resul== 1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
            echo(json_encode(true));
        }
        else{
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Pago no encontrado");
        }
    }
}


$pagoRest = new PagoRest();
URIDispatcher::getInstance()
    ->map("POST","/pago", array($pagoRest,"addPago"))
    ->map("GET","/pago/$1", array($pagoRest,"getPagosPropios"))
    ->map("DELETE","/pago/$1", array($pagoRest,"eliminarPago"))
    ->map("PUT","/pago/verifica/$1", array($pagoRest,"verificarPago"))
    ->map("PUT","/pago/rechazo/$1", array($pagoRest,"rechazarPago"))
    ->map("GET","/pago/identificador/$1", array($pagoRest,"descargarPago"))
    ->map("GET","/pagos/$1/$2", array($pagoRest,"getPagos"));


