<?php
require_once(__DIR__ . "/../model/Asistencia.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/AsistenciaMapper.php");
require_once(__DIR__."/../model/ConfiguracionMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class AsistenciaRest extends BaseRest {
    private $asistenciaMapper;
    private $configuracionMapper;

    public function __construct() {
        parent::__construct();

        $this->asistenciaMapper = new AsistenciaMapper();
        $this->configuracionMapper = new ConfiguracionMapper();
    }

    public function getAsistencia(){
        $currentUser = parent::verificarRol([3]);
        $result = $this->asistenciaMapper->getAsistenciaUsuario($currentUser->getEmail());

        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($result));

    }

    public function inscribirseComer($dia){
        $currentUser = parent::verificarRol([BaseRest::RESIDENTE]);
        $horaComida = new DateTime(); // Variable empleada para guardar la hora de la comida
        $horaLocal = new DateTime(); // Hora Local

        $configuracionData = $this->configuracionMapper->getConfiguracion();
        if(!$configuracionData){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Contacta con la directora, no están configurados los horarios"));
            exit();
        }
        $configuracion = new Configuracion($configuracionData['id'],$configuracionData['hora_comida'],$configuracionData['hora_cena'],$configuracionData['limite_hora_comida'],$configuracionData['limite_hora_cena']);
        $horaComer = $configuracion->getHoraComida(); // Hora de la comida
        $horaPartida = explode(':',$horaComer); // Separamos las horas : min : sec
        $diaPartido = explode('-',$dia); // Separamos por año-mes-dia
        $horaComida->setTime($horaPartida[0],$horaPartida[1]); // Asignamos la hora de la comida
        $horaComida->setDate($diaPartido[0],$diaPartido[1],$diaPartido[2]); // Asignamos la fecha de la comida

        $intervalo = 'PT'.$configuracion->getLimiteHoraComida().'H'; // Horas antes que se pueden anotar los residentes
        date_sub($horaComida,new DateInterval($intervalo)); // Modificamos la hora de la comida, esta ahora es la hora limite a la que se pueden anotar

        // Comparamos para ves si se puede anotar o no
        if($horaLocal<=$horaComida){
           $result =  $this->asistenciaMapper->inscribirseComida($dia,$currentUser->getEmail());
           if($result==1){
               // Sentencia ejecutada con exito
               header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
               header('Content-Type: application/json');
               echo (json_encode(true));
           }
           else{
               http_response_code(400);
               header('Content-Type: application/json');
               echo(json_encode("Error al anotarse a comer"));
           }
        }
        else{
            //Error no puedes cambiar
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Es demasiado tarde para inscribirte a comer"));
        }

    }

    public function inscribirseCenar($dia){
        $currentUser = parent::verificarRol([BaseRest::RESIDENTE]);
        $horaComida = new DateTime(); // Variable empleada para guardar la hora de la comida
        $horaLocal = new DateTime(); // Hora Local

        $configuracionData = $this->configuracionMapper->getConfiguracion();
        if(!$configuracionData){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Contacta con la directora, no están configurados los horarios"));
            exit();
        }
        $configuracion = new Configuracion($configuracionData['id'],$configuracionData['hora_comida'],$configuracionData['hora_cena'],$configuracionData['limite_hora_comida'],$configuracionData['limite_hora_cena']);
        $horaComer = $configuracion->getHoraCena(); // Hora de la comida
        $horaPartida = explode(':',$horaComer); // Separamos las horas : min : sec
        $diaPartido = explode('-',$dia); // Separamos por año-mes-dia
        $horaComida->setTime($horaPartida[0],$horaPartida[1]); // Asignamos la hora de la comida
        $horaComida->setDate($diaPartido[0],$diaPartido[1],$diaPartido[2]); // Asignamos la fecha de la comida

        $intervalo = 'PT'.$configuracion->getLimiteHoraCena().'H'; // Horas antes que se pueden anotar los residentes
        date_sub($horaComida,new DateInterval($intervalo)); // Modificamos la hora de la comida, esta ahora es la hora limite a la que se pueden anotar

        // Comparamos para ves si se puede anotar o no
        if($horaLocal<=$horaComida){
            $result =  $this->asistenciaMapper->inscribirseCena($dia,$currentUser->getEmail());
            if($result==1){
                // Sentencia ejecutada con exito
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                header('Content-Type: application/json');
                echo (json_encode(true));
            }
            else{
                http_response_code(400);
                header('Content-Type: application/json');
                echo(json_encode("Error al anotarse a cenar"));
            }
        }
        else{
            //Error no puedes cambiar
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Es demasiado tarde para inscribirte a cenar"));
        }

    }

    public function desinscribirseComer($dia){
        $currentUser = parent::verificarRol([BaseRest::RESIDENTE]);
        $horaComida = new DateTime(); // Variable empleada para guardar la hora de la comida
        $horaLocal = new DateTime(); // Hora Local

        $configuracionData = $this->configuracionMapper->getConfiguracion();
        if(!$configuracionData){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Contacta con la directora, no están configurados los horarios"));
            exit();
        }
        $configuracion = new Configuracion($configuracionData['id'],$configuracionData['hora_comida'],$configuracionData['hora_cena'],$configuracionData['limite_hora_comida'],$configuracionData['limite_hora_cena']);
        $horaComer = $configuracion->getHoraComida(); // Hora de la comida
        $horaPartida = explode(':',$horaComer); // Separamos las horas : min : sec
        $diaPartido = explode('-',$dia); // Separamos por año-mes-dia
        $horaComida->setTime($horaPartida[0],$horaPartida[1]); // Asignamos la hora de la comida
        $horaComida->setDate($diaPartido[0],$diaPartido[1],$diaPartido[2]); // Asignamos la fecha de la comida

        $intervalo = 'PT'.$configuracion->getLimiteHoraComida().'H'; // Horas antes que se pueden anotar los residentes
        date_sub($horaComida,new DateInterval($intervalo)); // Modificamos la hora de la comida, esta ahora es la hora limite a la que se pueden anotar

        // Comparamos para ves si se puede anotar o no
        if($horaLocal<=$horaComida){
            $result =  $this->asistenciaMapper->desinscribirseComida($dia,$currentUser->getEmail());
            if($result==1){
                // Sentencia ejecutada con exito
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                header('Content-Type: application/json');
                echo (json_encode(true));
            }
            else{
                http_response_code(400);
                header('Content-Type: application/json');
                echo(json_encode("Error al desinscribirse a comer"));
            }
        }
        else{
            //Error no puedes cambiar
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Es demasiado tarde para desinscribirte a comer"));
        }


    }

    public function desinscribirseCenar($dia){
        $currentUser = parent::verificarRol([BaseRest::RESIDENTE]);
        $horaComida = new DateTime(); // Variable empleada para guardar la hora de la comida
        $horaLocal = new DateTime(); // Hora Local

        $configuracionData = $this->configuracionMapper->getConfiguracion();
        if(!$configuracionData){
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Contacta con la directora, no están configurados los horarios"));
            exit();
        }
        $configuracion = new Configuracion($configuracionData['id'],$configuracionData['hora_comida'],$configuracionData['hora_cena'],$configuracionData['limite_hora_comida'],$configuracionData['limite_hora_cena']);
        $horaComer = $configuracion->getHoraComida(); // Hora de la comida
        $horaPartida = explode(':',$horaComer); // Separamos las horas : min : sec
        $diaPartido = explode('-',$dia); // Separamos por año-mes-dia
        $horaComida->setTime($horaPartida[0],$horaPartida[1]); // Asignamos la hora de la comida
        $horaComida->setDate($diaPartido[0],$diaPartido[1],$diaPartido[2]); // Asignamos la fecha de la comida

        $intervalo = 'PT'.$configuracion->getLimiteHoraComida().'H'; // Horas antes que se pueden anotar los residentes
        date_sub($horaComida,new DateInterval($intervalo)); // Modificamos la hora de la comida, esta ahora es la hora limite a la que se pueden anotar

        // Comparamos para ves si se puede anotar o no
        if($horaLocal<=$horaComida){
            $result =  $this->asistenciaMapper->desinscribirseCena($dia,$currentUser->getEmail());
            if($result==1){
                // Sentencia ejecutada con exito
                header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
                header('Content-Type: application/json');
                echo (json_encode(true));
            }
            else{
                http_response_code(400);
                header('Content-Type: application/json');
                echo(json_encode("Error al desinscribirse de cenar"));
            }
        }
        else{
            //Error no puedes cambiar
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Es demasiado tarde para desinscribirte a cenar"));
        }

    }

    function asistenciaComida($dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->getResidentesInscritosComida($dia);
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($resul));
    }

    function asistenciaDia($dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->getResidentesInscritosDia($dia);
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($resul));
    }

    function asistenciaCena($dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->getResidentesInscritosCena($dia);
        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo (json_encode($resul));

    }

    function asisteCena($residente,$dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->setAsisteCena($residente,$dia);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
        }else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al cambiar la asistencia"));
        }
    }

    function asisteComida($residente,$dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->setAsisteComida($residente,$dia);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
        }else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al cambiar la asistencia"));
        }
    }

    function noAsisteCena($residente,$dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->setNoAsisteCena($residente,$dia);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
        }else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al cambiar la asistencia"));
        }
    }

    function noAsisteComida($residente,$dia){
        $this->verificarRol([0,1,2]);
        $resul = $this->asistenciaMapper->setNoAsisteComida($residente,$dia);
        if($resul==1){
            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
            header('Content-Type: application/json');
        }else{
            http_response_code(400);
            header('Content-Type: application/json');
            echo(json_encode("Error al cambiar la asistencia"));
        }
    }



}

$asistenciaRest = new AsistenciaRest();
URIDispatcher::getInstance()
    ->map("GET","/asistencia", array($asistenciaRest,"getAsistencia"))
    ->map("PUT","/asistencia/comer/$1", array($asistenciaRest,"inscribirseComer"))
    ->map("PUT","/asistencia/cenar/$1", array($asistenciaRest,"inscribirseCenar"))
    ->map("POST","/asistencia/si-come/$1/$2", array($asistenciaRest,"asisteComida"))
    ->map("POST","/asistencia/si-cena/$1/$2", array($asistenciaRest,"asisteCena"))
    ->map("POST","/asistencia/no-come/$1/$2", array($asistenciaRest,"noAsisteComida"))
    ->map("POST","/asistencia/no-cena/$1/$2", array($asistenciaRest,"noAsisteCena"))
    ->map("GET","/asistencia/cena/$1", array($asistenciaRest,"asistenciaCena"))
    ->map("GET","/asistencia/dia/$1", array($asistenciaRest,"asistenciaDia"))
    ->map("GET","/asistencia/comida/$1", array($asistenciaRest,"asistenciaComida"))
    ->map("PUT","/asistencia/desinscribirse-comer/$1", array($asistenciaRest,"desinscribirseComer"))
    ->map("PUT","/asistencia/desinscribirse-cenar/$1", array($asistenciaRest,"desinscribirseCenar"));
