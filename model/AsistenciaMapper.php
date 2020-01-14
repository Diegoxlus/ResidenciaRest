<?php
require_once(__DIR__ ."/../core/PDOConnection.php");

class AsistenciaMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }



}
