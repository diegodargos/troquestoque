<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_log_cliente_matricula{

	private $PK_ClienteMatricula = 0;
	private $FK_Cliente = 0;
	private $FK_ClienteMatricula = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $CPF = null;
	private $NumeroMatricula = null;
	private $MargemDisponivel = null;
	private $Informacao = null;
	private $KeyField = "PK_ClienteMatricula";
	private $Engine = "InnoDB";

	public function setPK_ClienteMatricula($PK_ClienteMatricula){
		$this->PK_ClienteMatricula = intval($PK_ClienteMatricula);
	}

	public function setFK_Cliente($FK_Cliente){
		if(is_null($FK_Cliente)) throw new Exception("Valor Nulo Inválido no campo [FK_Cliente]");
		if(!is_int($FK_Cliente)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Cliente]");
		$this->FK_Cliente = intval($FK_Cliente);
	}

	public function setFK_ClienteMatricula($FK_ClienteMatricula){
		if(is_null($FK_ClienteMatricula)) throw new Exception("Valor Nulo Inválido no campo [FK_ClienteMatricula]");
		if(!is_int($FK_ClienteMatricula)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_ClienteMatricula]");
		$this->FK_ClienteMatricula = intval($FK_ClienteMatricula);
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

	public function setNumeroMatricula($NumeroMatricula){
		$this->NumeroMatricula = $NumeroMatricula;
	}

	public function setMargemDisponivel($MargemDisponivel){
		$this->MargemDisponivel = floatval($MargemDisponivel);
	}

	public function setInformacao($Informacao){
		$this->Informacao = $Informacao;
	}

	public function getPK_ClienteMatricula(){
		return intval($this->PK_ClienteMatricula);
	}

	public function getFK_Cliente(){
		return intval($this->FK_Cliente);
	}

	public function getFK_ClienteMatricula(){
		return intval($this->FK_ClienteMatricula);
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

	public function getNumeroMatricula(){
		return $this->NumeroMatricula;
	}

	public function getMargemDisponivel(){
		return floatval($this->MargemDisponivel);
	}

	public function getInformacao(){
		return $this->Informacao;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>