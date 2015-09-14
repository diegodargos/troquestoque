<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_log_importacao_data{

	private $PK_ImportacaoData = 0;
	private $FK_Importacao = null;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $NumeroContrato = null;
	private $CPF = "";
	private $Matricula1 = null;
	private $Identificador1 = null;
	private $Matricula2 = null;
	private $Identificador2 = null;
	private $Parcela = "";
	private $Prazo = 0;
	private $ValorFinanciado = "";
	private $ValorInadimplente = "";
	private $TaxaContrato = null;
	private $ValorExtra = null;
	private $IOF = null;
	private $ValorRepasse = null;
	private $KeyField = "PK_ImportacaoData";
	private $Engine = "InnoDB";

	public function setPK_ImportacaoData($PK_ImportacaoData){
		$this->PK_ImportacaoData = intval($PK_ImportacaoData);
	}

	public function setFK_Importacao($FK_Importacao){
		if($FK_Importacao == "" || $FK_Importacao == false) $FK_Importacao= null;
		if(!is_int($FK_Importacao)  && !is_null($FK_Importacao)) throw new Exception("Apenas valores inteiros são validos no campo [FK_Importacao]");
		$this->FK_Importacao = intval($FK_Importacao);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setNumeroContrato($NumeroContrato){
		$this->NumeroContrato = $NumeroContrato;
	}

	public function setCPF($CPF){
		if(is_null($CPF)) throw new Exception("Valor Nulo Inválido no campo [CPF]");
		if(!is_string($CPF)) throw new Exception("Apenas texto é permitido no campo [CPF]");
		$this->CPF = $CPF;
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

	public function setValorExtra($ValorExtra){
		$this->ValorExtra = floatval($ValorExtra);
	}

	public function setIOF($IOF){
		$this->IOF = floatval($IOF);
	}

	public function setValorRepasse($ValorRepasse){
		$this->ValorRepasse = floatval($ValorRepasse);
	}

	public function getPK_ImportacaoData(){
		return intval($this->PK_ImportacaoData);
	}

	public function getFK_Importacao(){
		return intval($this->FK_Importacao);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getNumeroContrato(){
		return $this->NumeroContrato;
	}

	public function getCPF(){
		return $this->CPF;
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

	public function getValorExtra(){
		return floatval($this->ValorExtra);
	}

	public function getIOF(){
		return floatval($this->IOF);
	}

	public function getValorRepasse(){
		return floatval($this->ValorRepasse);
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>