<?php
require_once("config/config.php");

$conexao = new Sql();

$user = new Usuario();

echo $conexao->select("SELECT * FROM tb_usuario");

?>