<?php
require_once(__DIR__ . "/../model/Parte.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/ParteMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class ParteRest extends BaseRest {
    private $parteMapper;

    public function __construct() {
        parent::__construct();

        $this->parteMapper = new ParteMapper();
    }

}
