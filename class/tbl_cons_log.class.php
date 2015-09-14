<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_cons_log{

	private $PK_Log = 0;
	private $FK_Convenio = 0;
	private $FK_Movimento = 0;
	private $FK_ClienteMatricula = 0;
	private $FK_Cliente = 0;
	private $DateTimeInsert = "";
	private $Margem = "";
	private $CPF = "";
	private $NumeroMatricula = "";
	private $Mensagem = null;
	private $KeyField = "PK_Log";
	private $Engine = "InnoDB";

	public function setPK_Log($PK_Log){
		$this->PK_Log = intval($PK_Log);
	}

	public function setFK_Convenio($FK_Convenio){
		if(is_null($FK_Convenio)) throw new Exception("Valor Nulo Inválido no campo [FK_Convenio]");
		if(!is_int($FK_Convenio)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setFK_Movimento($FK_Movimento){
		if(is_null($FK_Movimento)) throw new Exception("Valor Nulo Inválido no campo [FK_Movimento]");
		if(!is_int($FK_Movimento)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Movimento]");
		$this->FK_Movimento = intval($FK_Movimento);
	}

	public function setFK_ClienteMatricula($FK_ClienteMatricula){
		if(is_null($FK_ClienteMatricula)) throw new Exception("Valor Nulo Inválido no campo [FK_ClienteMatricula]");
		if(!is_int($FK_ClienteMatricula)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_ClienteMatricula]");
		$this->FK_ClienteMatricula = intval($FK_ClienteMatricula);
	}

	public function setFK_Cliente($FK_Cliente){
		if(is_null($FK_Cliente)) throw new Exception("Valor Nulo Inválido no campo [FK_Cliente]");
		if(!is_int($FK_Cliente)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Cliente]");
		$this->FK_Cliente = intval($FK_Cliente);
	}

	public function setDateTimeInsert($DateTimeInsert){
		if(is_null($DateTimeInsert)) throw new Exception("Valor Nulo Inválido no campo [DateTimeInsert]");
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setMargem($Margem){
		if(is_null($Margem)) throw new Exception("Valor Nulo Inválido no campo [Margem]");
		$this->Margem = floatval($Margem);
	}

	public function setCPF($CPF){
		if(is_null($CPF)) throw new Exception("Valor Nulo Inválido no campo [CPF]");
		if(!is_string($CPF)) throw new Exception("Apenas texto é permitido no campo [CPF]");
		$this->CPF = $CPF;
	}

	public function setNumeroMatricula($NumeroMatricula){
		if(is_null($NumeroMatricula)) throw new Exception("Valor Nulo Inválido no campo [NumeroMatricula]");
		if(!is_string($NumeroMatricula)) throw new Exception("Apenas texto é permitido no campo [NumeroMatricula]");
		$this->NumeroMatricula = $NumeroMatricula;
	}

	public function setMensagem($Mensagem){
		$this->Mensagem = $Mensagem;
	}

	public function getPK_Log(){
		return intval($this->PK_Log);
	}

	public function getFK_Convenio(){
		return intval($this->FK_Convenio);
	}

	public function getFK_Movimento(){
		return intval($this->FK_Movimento);
	}

	public function getFK_ClienteMatricula(){
		return intval($this->FK_ClienteMatricula);
	}

	public function getFK_Cliente(){
		return intval($this->FK_Cliente);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getMargem(){
		return floatval($this->Margem);
	}

	public function getCPF(){
		return $this->CPF;
	}

	public function getNumeroMatricula(){
		return $this->NumeroMatricula;
	}

	public function getMensagem(){
		return $this->Mensagem;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>