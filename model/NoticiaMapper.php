<?php
require_once(__DIR__ ."/../core/PDOConnection.php");


class NoticiaMapper
{
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function editarNoticia(Noticia $noticia)
    {
        $stmt = $this->db->prepare("UPDATE noticia SET titulo = ? , descripcion=?, dia=? WHERE noticia.id = ?");
        $resul = $stmt->execute(array($noticia->getTitulo(),$noticia->getDescripcion(),$noticia->getDia(), $noticia->getId()));
        return $resul;

    }

    public function getNoticias()
    {
        $stmt = $this->db->prepare("SELECT * FROM noticia");
        $stmt->execute(array());
        $resul = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resul;
    }

    public function eliminarNoticia($id)
    {
        $stmt = $this->db->prepare("DELETE from noticia WHERE id = ?");
        $resul = $stmt->execute(array($id));
        return $resul;
    }

    public function addNoticia(Noticia $noticia)
    {
        $stmt = $this->db->prepare("INSERT INTO noticia VALUES ('',?,?,?)");
        $resul = $stmt->execute(array($noticia->getDia(),$noticia->getTitulo(),$noticia->getDescripcion()));
        return $resul;
    }

}
