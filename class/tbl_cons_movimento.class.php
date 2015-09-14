<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 05/06/2015 11:24:59
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_cons_movimento{

	private $PK_Movimento = 0;
	private $FK_Convenio = 0;
	private $FK_ImportacaoData = null;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $CPF = null;
	private $NumeroMatricula = null;
	private $ValorParcela = null;
	private $Status = "";
	private $UsuarioServidor = null;
	private $SenhaServidor = null;
	private $KeyField = "PK_Movimento";
	private $Engine = "InnoDB";

	public function setPK_Movimento($PK_Movimento){
		$this->PK_Movimento = $PK_Movimento;
	}

	public function setFK_Convenio($FK_Convenio){
		if(is_null($FK_Convenio)) throw new Exception("Valor Nulo Inválido no campo [FK_Convenio]");
		if(!is_int($FK_Convenio)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setFK_ImportacaoData($FK_ImportacaoData){
		if($FK_ImportacaoData == "" || $FK_ImportacaoData == false) $FK_ImportacaoData= null;
		if(!is_int($FK_ImportacaoData)  && !is_null($FK_ImportacaoData)) throw new Exception("Apenas valores inteiros são validos no campo [FK_ImportacaoData]");
		$this->FK_ImportacaoData = intval($FK_ImportacaoData);
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

	public function setValorParcela($ValorParcela){
		$this->ValorParcela = floatval($ValorParcela);
	}

	public function setStatus($Status){
		if(is_null($Status)) throw new Exception("Valor Nulo Inválido no campo [Status]");
		if(!is_string($Status)) throw new Exception("Apenas texto é permitido no campo [Status]");
		$this->Status = $Status;
	}

	public function setUsuarioServidor($UsuarioServidor){
		$this->UsuarioServidor = $UsuarioServidor;
	}

	public function setSenhaServidor($SenhaServidor){
		$this->SenhaServidor = $SenhaServidor;
	}

	public function getPK_Movimento(){
		return intval($this->PK_Movimento);
	}

	public function getFK_Convenio(){
		return intval($this->FK_Convenio);
	}

	public function getFK_ImportacaoData(){
		return intval($this->FK_ImportacaoData);
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

	public function getValorParcela(){
		return floatval($this->ValorParcela);
	}

	public function getStatus(){
		return $this->Status;
	}

	public function getUsuarioServidor(){
		return $this->UsuarioServidor;
	}

	public function getSenhaServidor(){
		return $this->SenhaServidor;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

	public function getFieldsDefault(){
		return array("Status");
	}

}
?>