<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_cartao_log{

	private $PK_Log = 0;
	private $FK_Movimento = 0;
	private $FK_Convenio = 0;
	private $DateTimeInsert = "";
	private $CPF = null;
	private $NumeroMatricula = null;
	private $Mensagem = "";
	private $Margem = null;
	private $KeyField = "PK_Log";
	private $Engine = "InnoDB";

	public function setPK_Log($PK_Log){
		$this->PK_Log = intval($PK_Log);
	}

	public function setFK_Movimento($FK_Movimento){
		if(is_null($FK_Movimento)) throw new Exception("Valor Nulo Inválido no campo [FK_Movimento]");
		if(!is_int($FK_Movimento)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Movimento]");
		$this->FK_Movimento = intval($FK_Movimento);
	}

	public function setFK_Convenio($FK_Convenio){
		if(is_null($FK_Convenio)) throw new Exception("Valor Nulo Inválido no campo [FK_Convenio]");
		if(!is_int($FK_Convenio)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setDateTimeInsert($DateTimeInsert){
		if(is_null($DateTimeInsert)) throw new Exception("Valor Nulo Inválido no campo [DateTimeInsert]");
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setCPF($CPF){
		$this->CPF = $CPF;
	}

	public function setNumeroMatricula($NumeroMatricula){
		$this->NumeroMatricula = $NumeroMatricula;
	}

	public function setMensagem($Mensagem){
		if(is_null($Mensagem)) throw new Exception("Valor Nulo Inválido no campo [Mensagem]");
		if(!is_string($Mensagem)) throw new Exception("Apenas texto é permitido no campo [Mensagem]");
		$this->Mensagem = $Mensagem;
	}

	public function setMargem($Margem){
		$this->Margem = floatval($Margem);
	}

	public function getPK_Log(){
		return intval($this->PK_Log);
	}

	public function getFK_Movimento(){
		return intval($this->FK_Movimento);
	}

	public function getFK_Convenio(){
		return intval($this->FK_Convenio);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
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

	public function getMargem(){
		return floatval($this->Margem);
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>