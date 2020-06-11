<?php
class Usuario{

	private $id_user;
	private $deslogin;
	private $dessenha;
	private $dtcastro;

	public function __construct($login = "" , $pass = ""){
		$this->setLogin($login);
		$this->setSenha($pass);
	}

	public function __toString(){

		return json_encode(array(
			'ID'=> $this->getId(),
			'LOGIN' => $this->getLogin(),
			'SENHA' => $this->getSenha(),
			'DATA CADASTRO' => $this->getDate()->format("d/m/Y")
		));

	}

	public function setData($data){
		$this->setId($data['id_user']);
		$this->setLogin($data['deslogin']);
		$this->setSenha($data['dessenha']);
		$this->setDate(new DateTime($data['dtcastro']));
	}

	public function loadById($id){

		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE id_user = :ID" , array(':ID' => $id));

		if(count($result) > 0){
			$this->setData($result[0]);
		}
	}

	public static function getList(){
		$sql = new Sql();
		return $result = $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin");
	}

	public static function search($login){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :search" , array(':search' => '%' . $login . '%'));
		return $result ;
	}

	public function login($login,$pass){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :log AND dessenha = :sen" , array(
			':log' => $login ,
			':sen' => $pass
		));


		if(count($result) > 0){
		$this->setData($result[0]);
			
		}else{
			throw new Exception("Usuário não encontrado", 1);
			
		}
	}

	public function insert(){

		$sql = new Sql();
		switch(Conexao::$nome_banco){

			case 'MYSQL':
				$result = $sql->select("CALL sp_usuarios_insert(:log , :pass)" , array(
				':log'=>$this->getLogin(),
				':pass'=>$this->getSenha()
				));
			break;
			case 'SQLSERVER':
				$result = $sql->select("EXECUTE sp_usuarios_insert(:log , :pass)" , array(
				':log'=>$this->getLogin(),
				':pass'=>$this->getSenha()
				));
			break;
		}

		if(count($result) > 0){
			$this->setData($result[0]);
		}
	}


	public function update($login , $password){

		$this->setLogin($login);
		$this->setSenha($password);
		$sql = new Sql();
		$sql->query("UPDATE tb_usuario SET deslogin = :log , dessenha = :pass WHERE id_user = :id" , array(
			':log'=> $this->getLogin(),
			':pass'=> $this->getSenha(),
			':id' => $this->getId()
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