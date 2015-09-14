<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_user{

	private $PK_User = 0;
	private $FK_Convenio = null;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $CPF = null;
	private $Nome = null;
	private $Login = "";
	private $Password = "";
	private $Email = "";
	private $Root = "";
	private $Admin = "";
	private $KeyField = "PK_User";
	private $Engine = "InnoDB";

	public function setPK_User($PK_User){
		$this->PK_User = intval($PK_User);
	}

	public function setFK_Convenio($FK_Convenio){
		if($FK_Convenio == "" || $FK_Convenio == false) $FK_Convenio= null;
		if(!is_int($FK_Convenio)  && !is_null($FK_Convenio)) throw new Exception("Apenas valores inteiros são validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setCPF($CPF){
		$this->CPF = $CPF;
	}

	public function setNome($Nome){
		$this->Nome = $Nome;
	}

	public function setLogin($Login){
		if(is_null($Login)) throw new Exception("Valor Nulo Inválido no campo [Login]");
		if(!is_string($Login)) throw new Exception("Apenas texto é permitido no campo [Login]");
		$this->Login = $Login;
	}

	public function setPassword($Password){
		if(is_null($Password)) throw new Exception("Valor Nulo Inválido no campo [Password]");
		if(!is_string($Password)) throw new Exception("Apenas texto é permitido no campo [Password]");
		$this->Password = $Password;
	}

	public function setEmail($Email){
		if(is_null($Email)) throw new Exception("Valor Nulo Inválido no campo [Email]");
		if(!is_string($Email)) throw new Exception("Apenas texto é permitido no campo [Email]");
		$this->Email = $Email;
	}

	public function setRoot($Root){
		if(is_null($Root)) throw new Exception("Valor Nulo Inválido no campo [Root]");
		$this->Root = $Root;
	}

	public function setAdmin($Admin){
		if(is_null($Admin)) throw new Exception("Valor Nulo Inválido no campo [Admin]");
		$this->Admin = $Admin;
	}

	public function getPK_User(){
		return intval($this->PK_User);
	}

	public function getFK_Convenio(){
		return intval($this->FK_Convenio);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getCPF(){
		return $this->CPF;
	}

	public function getNome(){
		return $this->Nome;
	}

	public function getLogin(){
		return $this->Login;
	}

	public function getPassword(){
		return $this->Password;
	}

	public function getEmail(){
		return $this->Email;
	}

	public function getRoot(){
		return $this->Root;
	}

	public function getAdmin(){
		return $this->Admin;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>