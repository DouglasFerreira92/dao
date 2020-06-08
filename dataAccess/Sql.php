<?php
class Sql{

	
	//RECEBE A STRING DE CONEXÃO E OS PARAMETROS
	public function query($rowQuery , $params = array()){
		$stmt = Conexao::getInstance()->prepare($rowQuery);
		$this->parametersBind($stmt , $params);
		$stmt->execute();
		return $stmt ;
	}

	// PEGA STATMENT E FAZ O BIND PARAM
	private function parametersBind($stmt , $parameter = array()){

		foreach($parameter as $chave => $valor){
			$this->parameterBind($stmt , $chave , $valor);
		}

	}

	private function parameterBind($statment , $chave , $valor){
		$statment->bindParam($chave , $valor);
	}

	public function select($rowQuery , $parameters = array()){
		$stmt = $this->query($rowQuery , $parameters);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($result);
	}


}
?>