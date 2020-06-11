<?php
require_once("config/config.php");

/*
$user = new Usuario("joaodecarvalhoneto","joao123");
$user->insert();
echo $user ;
*/

$user = new Usuario();

$user->loadById('5');

$user->update("natasha" , "5349234");

echo $user ;