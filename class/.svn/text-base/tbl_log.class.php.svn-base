<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_log{

	private $PK_Log = 0;
	private $FK_User = 0;
	private $DateTimeInsert = null;
	private $Operacao = "";
	private $Pagina = null;
	private $PK_Registro = 0;
	private $Data = null;
	private $IP = "";
	private $KeyField = "PK_Log";
	private $Engine = "InnoDB";

	public function setPK_Log($PK_Log){
		$this->PK_Log = intval($PK_Log);
	}

	public function setFK_User($FK_User){
		if(is_null($FK_User)) throw new Exception("Valor Nulo Inválido no campo [FK_User]");
		if(!is_int($FK_User)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_User]");
		$this->FK_User = intval($FK_User);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setOperacao($Operacao){
		if(is_null($Operacao)) throw new Exception("Valor Nulo Inválido no campo [Operacao]");
		if(!is_string($Operacao)) throw new Exception("Apenas texto é permitido no campo [Operacao]");
		$this->Operacao = $Operacao;
	}

	public function setPagina($Pagina){
		$this->Pagina = $Pagina;
	}

	public function setPK_Registro($PK_Registro){
		if(is_null($PK_Registro)) throw new Exception("Valor Nulo Inválido no campo [PK_Registro]");
		if(!is_int($PK_Registro)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [PK_Registro]");
		$this->PK_Registro = intval($PK_Registro);
	}

	public function setData($Data){
		$this->Data = $Data;
	}

	public function setIP($IP){
		if(is_null($IP)) throw new Exception("Valor Nulo Inválido no campo [IP]");
		if(!is_string($IP)) throw new Exception("Apenas texto é permitido no campo [IP]");
		$this->IP = $IP;
	}

	public function getPK_Log(){
		return intval($this->PK_Log);
	}

	public function getFK_User(){
		return intval($this->FK_User);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getOperacao(){
		return $this->Operacao;
	}

	public function getPagina(){
		return $this->Pagina;
	}

	public function getPK_Registro(){
		return intval($this->PK_Registro);
	}

	public function getData(){
		return $this->Data;
	}

	public function getIP(){
		return $this->IP;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>