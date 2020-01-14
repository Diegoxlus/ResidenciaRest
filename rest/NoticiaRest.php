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

}
