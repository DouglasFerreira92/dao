<?php
class Conexao extends PDO{

	private static $instance;
	public static $nome_banco = "MYSQL" ;
	private const  DB_NAME = 'db_php' ;
	private const  DB_HOST = 'localhost';
	private const  DB_USER = 'root';
	private const  DB_PASS = '';

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new PDO("mysql:dbname=".self::DB_NAME.";host=".self::DB_HOST.";charset=utf8" , self::DB_USER , self::DB_PASS);
		}
		return self::$instance ;
	}

}