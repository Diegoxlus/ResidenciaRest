<?php
require_once(__DIR__ . "/../model/Norma.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/NormaMapper.php");
require_once(__DIR__ . "/BaseRest.php");

class NormaRest extends BaseRest {
    private $normaMapper;

    public function __construct() {
        parent::__construct();

        $this->normaMapper = new NormaMapper();
    }

}
