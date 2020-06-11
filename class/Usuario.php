<?php
class Usuario{

	private $id_user;
	private $deslogin;
	private $dessenha;
	private $dtcastro;

	//MÉTODO CONSTRUTOR
	public function __construct($login = "" , $pass = ""){
		$this->setLogin($login);
		$this->setSenha($pass);
	}
	//RETONA JSON QUANDO EXIBIR OBJETO
	public function __toString(){

		return json_encode(array(
			'ID'=> $this->getId(),
			'LOGIN' => $this->getLogin(),
			'SENHA' => $this->getSenha(),
			'DATA CADASTRO' => $this->getDate()->format("d/m/Y")
		));

	}
	//SETA OS DADOS NOS ATRIBUTOS DA CLASSE
	public function setData($data){
		$this->setId($data['id_user']);
		$this->setLogin($data['deslogin']);
		$this->setSenha($data['dessenha']);
		$this->setDate(new DateTime($data['dtcastro']));
	}
	//CARREGA PELO ID
	public function loadById($id){

		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE id_user = :ID" , array(':ID' => $id));

		if(count($result) > 0){
			$this->setData($result[0]);
		}
	}
	//SELECIONA TUDO DA TABELA
	public static function getList(){
		$sql = new Sql();
		return $result = $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin");
	}
	//SELECIONA PELO LOGIN
	public static function search($login){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :search" , array(':search' => '%' . $login . '%'));
		return $result ;
	}
	//VALIDA LOGIN E SENHA
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
	//INSERE NOVO USUARIO
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

	//FAZ A ATUALIZAÇÃO
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
	//DELETA USUARIO
	public function delete(){
		$sql = new Sql();
		$sql->query("DELETE FROM tb_usuario WHERE id_user = :id" , array(
			':id' => $this->getId()
		));

		$this->setId(null);
		$this->setLogin('');
		$this->setSenha('');
		$this->setDate(new DateTime());
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