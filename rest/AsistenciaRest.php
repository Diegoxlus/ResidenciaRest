<?php
require_once(__DIR__ . "/../model/Asistencia.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/AsistenciaMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class AsistenciaRest extends BaseRest {
    private $asistenciaMapper;

    public function __construct() {
        parent::__construct();

        $this->asistenciaMapper = new AsistenciaMapper();
    }

}
