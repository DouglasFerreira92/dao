<?php

class Usuario{

	private $id_user;
	private $deslogin;
	private $dessenha;
	private $dtcastro;


	public function loadById($id){

		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE id_user = :ID" , array(':ID' => $id));

		if(count($result) > 0){

			$linha = $result[0];
			$this->setId($linha['id_user']);
			$this->setLogin($linha['deslogin']);
			$this->setSenha($linha['dessenha']);
			$this->setDate(new DateTime(($linha['dtcastro']));
		}
	}

	public function __toString(){

		return json_encode(array(
			'ID'=> $this->getId(),
			'LOGIN' => $this->getLogin(),
			'SENHA' => $this->getSenha(),
			'DATA CADASTRO' => $this->getDate()
		));

	}

//========================GETTER E SETTER====================================

	public function getId(){
		return $this->id_user;
	}
	public function setId($id){
		$this->id_user = $id ;
	}
	public function getLogin(){
		return $this->deslogin;
	}
	public function setLogin($login){
		$this->deslogin = $login ;
	}
	public function getSenha(){
		return $this->dessenha;
	}
	public function setSenha($pass){
		$this->dessenha = $pass ;
	}
	public function getDate(){
		return $this->dtcastro;
	}
	public function setDate($date){
		$this->dtcastro = $date ;
	}

}