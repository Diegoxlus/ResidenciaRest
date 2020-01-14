<?php
require_once(__DIR__ . "/../model/Menu.php");
require_once(__DIR__."/../core/ValidationException.php");
require_once(__DIR__."/../model/MenuMapper.php");
require_once(__DIR__ . "/BaseRest.php");


class MenuRest extends BaseRest {
    private $menuMapper;

    public function __construct() {
        parent::__construct();

        $this->menuMapper = new MenuMapper();
    }

}
