<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_cartao_movimento{

	private $PK_Movimento = 0;
	private $FK_Convenio = 0;
	private $FK_Banco = 0;
	private $FK_ImportacaoData = null;
	private $DateTimeInsert = "";
	private $DateTimeUpdate = "";
	private $CPF = "";
	private $NumeroMatricula = "";
	private $NumeroContrato = "";
	private $ValorSolicitado = "";
	private $Status = "";
	private $ValorAverbado = null;
	private $DataOperacao = null;
	private $KeyField = "PK_Movimento";
	private $Engine = "InnoDB";

	public function setPK_Movimento($PK_Movimento){
		$this->PK_Movimento = intval($PK_Movimento);
	}

	public function setFK_Convenio($FK_Convenio){
		if(is_null($FK_Convenio)) throw new Exception("Valor Nulo Inválido no campo [FK_Convenio]");
		if(!is_int($FK_Convenio)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setFK_Banco($FK_Banco){
		if(is_null($FK_Banco)) throw new Exception("Valor Nulo Inválido no campo [FK_Banco]");
		if(!is_int($FK_Banco)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Banco]");
		$this->FK_Banco = intval($FK_Banco);
	}

	public function setFK_ImportacaoData($FK_ImportacaoData){
		if($FK_ImportacaoData == "" || $FK_ImportacaoData == false) $FK_ImportacaoData= null;
		if(!is_int($FK_ImportacaoData)  && !is_null($FK_ImportacaoData)) throw new Exception("Apenas valores inteiros são validos no campo [FK_ImportacaoData]");
		$this->FK_ImportacaoData = intval($FK_ImportacaoData);
	}

	public function setDateTimeInsert($DateTimeInsert){
		if(is_null($DateTimeInsert)) throw new Exception("Valor Nulo Inválido no campo [DateTimeInsert]");
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		if(is_null($DateTimeUpdate)) throw new Exception("Valor Nulo Inválido no campo [DateTimeUpdate]");
		$this->DateTimeUpdate = $DateTimeUpdate;
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

	public function setNumeroContrato($NumeroContrato){
		if(is_null($NumeroContrato)) throw new Exception("Valor Nulo Inválido no campo [NumeroContrato]");
		if(!is_string($NumeroContrato)) throw new Exception("Apenas texto é permitido no campo [NumeroContrato]");
		$this->NumeroContrato = $NumeroContrato;
	}

	public function setValorSolicitado($ValorSolicitado){
		if(is_null($ValorSolicitado)) throw new Exception("Valor Nulo Inválido no campo [ValorSolicitado]");
		$this->ValorSolicitado = floatval($ValorSolicitado);
	}

	public function setStatus($Status){
		if(is_null($Status)) throw new Exception("Valor Nulo Inválido no campo [Status]");
		if(!is_string($Status)) throw new Exception("Apenas texto é permitido no campo [Status]");
		$this->Status = $Status;
	}

	public function setValorAverbado($ValorAverbado){
		$this->ValorAverbado = floatval($ValorAverbado);
	}

	public function setDataOperacao($DataOperacao){
		$this->DataOperacao = $DataOperacao;
	}

	public function getPK_Movimento(){
		return intval($this->PK_Movimento);
	}

	public function getFK_Convenio(){
		return intval($this->FK_Convenio);
	}

	public function getFK_Banco(){
		return intval($this->FK_Banco);
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

	public function getNumeroContrato(){
		return $this->NumeroContrato;
	}

	public function getValorSolicitado(){
		return floatval($this->ValorSolicitado);
	}

	public function getStatus(){
		return $this->Status;
	}

	public function getValorAverbado(){
		return floatval($this->ValorAverbado);
	}

	public function getDataOperacao(){
		return $this->DataOperacao;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>