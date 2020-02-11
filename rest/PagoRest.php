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

}
