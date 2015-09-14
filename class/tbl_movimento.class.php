<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_movimento{

	private $PK_Movimento = 0;
	private $FK_Convenio = 0;
	private $FK_Banco = 0;
	private $FK_ImportacaoData = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $CPF = "";
	private $NumeroContrato = "";
	private $Matricula1 = null;
	private $Identificador1 = null;
	private $Matricula2 = null;
	private $Identificador2 = null;
	private $Parcela = "";
	private $Prazo = 0;
	private $ValorFinanciado = "";
	private $ValorInadimplente = "";
	private $TaxaContrato = null;
	private $ValorInadimplenteAtual = null;
	private $DataAtualizacao = null;
	private $Status = null;
	private $FK_MovimentoPai = null;
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
		if(is_null($FK_ImportacaoData)) throw new Exception("Valor Nulo Inválido no campo [FK_ImportacaoData]");
		if(!is_int($FK_ImportacaoData)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_ImportacaoData]");
		$this->FK_ImportacaoData = intval($FK_ImportacaoData);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setCPF($CPF){
		if(is_null($CPF)) throw new Exception("Valor Nulo Inválido no campo [CPF]");
		if(!is_string($CPF)) throw new Exception("Apenas texto é permitido no campo [CPF]");
		$this->CPF = $CPF;
	}

	public function setNumeroContrato($NumeroContrato){
		if(is_null($NumeroContrato)) throw new Exception("Valor Nulo Inválido no campo [NumeroContrato]");
		if(!is_string($NumeroContrato)) throw new Exception("Apenas texto é permitido no campo [NumeroContrato]");
		$this->NumeroContrato = $NumeroContrato;
	}

	public function setMatricula1($Matricula1){
		$this->Matricula1 = $Matricula1;
	}

	public function setIdentificador1($Identificador1){
		$this->Identificador1 = $Identificador1;
	}

	public function setMatricula2($Matricula2){
		$this->Matricula2 = $Matricula2;
	}

	public function setIdentificador2($Identificador2){
		$this->Identificador2 = $Identificador2;
	}

	public function setParcela($Parcela){
		if(is_null($Parcela)) throw new Exception("Valor Nulo Inválido no campo [Parcela]");
		$this->Parcela = floatval($Parcela);
	}

	public function setPrazo($Prazo){
		if(is_null($Prazo)) throw new Exception("Valor Nulo Inválido no campo [Prazo]");
		if(!is_int($Prazo)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [Prazo]");
		$this->Prazo = intval($Prazo);
	}

	public function setValorFinanciado($ValorFinanciado){
		if(is_null($ValorFinanciado)) throw new Exception("Valor Nulo Inválido no campo [ValorFinanciado]");
		$this->ValorFinanciado = floatval($ValorFinanciado);
	}

	public function setValorInadimplente($ValorInadimplente){
		if(is_null($ValorInadimplente)) throw new Exception("Valor Nulo Inválido no campo [ValorInadimplente]");
		$this->ValorInadimplente = floatval($ValorInadimplente);
	}

	public function setTaxaContrato($TaxaContrato){
		$this->TaxaContrato = floatval($TaxaContrato);
	}

	public function setValorInadimplenteAtual($ValorInadimplenteAtual){
		$this->ValorInadimplenteAtual = floatval($ValorInadimplenteAtual);
	}

	public function setDataAtualizacao($DataAtualizacao){
		$this->DataAtualizacao = $DataAtualizacao;
	}

	public function setStatus($Status){
		$this->Status = $Status;
	}

	public function setFK_MovimentoPai($FK_MovimentoPai){
		if($FK_MovimentoPai == "" || $FK_MovimentoPai == false) $FK_MovimentoPai= null;
		if(!is_int($FK_MovimentoPai)  && !is_null($FK_MovimentoPai)) throw new Exception("Apenas valores inteiros são validos no campo [FK_MovimentoPai]");
		$this->FK_MovimentoPai = intval($FK_MovimentoPai);
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

	public function getNumeroContrato(){
		return $this->NumeroContrato;
	}

	public function getMatricula1(){
		return $this->Matricula1;
	}

	public function getIdentificador1(){
		return $this->Identificador1;
	}

	public function getMatricula2(){
		return $this->Matricula2;
	}

	public function getIdentificador2(){
		return $this->Identificador2;
	}

	public function getParcela(){
		return floatval($this->Parcela);
	}

	public function getPrazo(){
		return intval($this->Prazo);
	}

	public function getValorFinanciado(){
		return floatval($this->ValorFinanciado);
	}

	public function getValorInadimplente(){
		return floatval($this->ValorInadimplente);
	}

	public function getTaxaContrato(){
		return floatval($this->TaxaContrato);
	}

	public function getValorInadimplenteAtual(){
		return floatval($this->ValorInadimplenteAtual);
	}

	public function getDataAtualizacao(){
		return $this->DataAtualizacao;
	}

	public function getStatus(){
		return $this->Status;
	}

	public function getFK_MovimentoPai(){
		return intval($this->FK_MovimentoPai);
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>