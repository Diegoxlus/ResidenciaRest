<?php
require_once(__DIR__ ."/../core/PDOConnection.php");


class ParteMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

}
