<?php
require_once("config/config.php");


$user = new Usuario();
$user->login('DouglasFerreira92' , '123456');

echo $user ;