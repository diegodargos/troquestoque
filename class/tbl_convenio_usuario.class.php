<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_convenio_usuario{

	private $PK_Convenio_Usuario = 0;
	private $FK_Convenio = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Usuario = "";
	private $Senha = "";
	private $Expira = "";
	private $Validade = null;
	private $Ativo = "";
	private $KeyField = "PK_Convenio_Usuario";
	private $Engine = "InnoDB";

	public function setPK_Convenio_Usuario($PK_Convenio_Usuario){
		$this->PK_Convenio_Usuario = intval($PK_Convenio_Usuario);
	}

	public function setFK_Convenio($FK_Convenio){
		if(is_null($FK_Convenio)) throw new Exception("Valor Nulo Inválido no campo [FK_Convenio]");
		if(!is_int($FK_Convenio)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setUsuario($Usuario){
		if(is_null($Usuario)) throw new Exception("Valor Nulo Inválido no campo [Usuario]");
		if(!is_string($Usuario)) throw new Exception("Apenas texto é permitido no campo [Usuario]");
		$this->Usuario = $Usuario;
	}

	public function setSenha($Senha){
		if(is_null($Senha)) throw new Exception("Valor Nulo Inválido no campo [Senha]");
		if(!is_string($Senha)) throw new Exception("Apenas texto é permitido no campo [Senha]");
		$this->Senha = $Senha;
	}

	public function setExpira($Expira){
		if(is_null($Expira)) throw new Exception("Valor Nulo Inválido no campo [Expira]");
		$this->Expira = $Expira;
	}

	public function setValidade($Validade){
		$this->Validade = $Validade;
	}

	public function setAtivo($Ativo){
		if(is_null($Ativo)) throw new Exception("Valor Nulo Inválido no campo [Ativo]");
		$this->Ativo = $Ativo;
	}

	public function getPK_Convenio_Usuario(){
		return intval($this->PK_Convenio_Usuario);
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

	public function getUsuario(){
		return $this->Usuario;
	}

	public function getSenha(){
		return $this->Senha;
	}

	public function getExpira(){
		return $this->Expira;
	}

	public function getValidade(){
		return $this->Validade;
	}

	public function getAtivo(){
		return $this->Ativo;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>