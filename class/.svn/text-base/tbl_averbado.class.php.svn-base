<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_averbado{

	private $PK_Averbado = 0;
	private $FK_Reserva = 0;
	private $FK_ConvenioUsuario = 0;
	private $FK_Movimento = null;
	private $DateTimeInsert = "";
	private $DateTimeUpdate = "";
	private $CPF = null;
	private $NumeroMatricula = null;
	private $FatorUtilizado = "";
	private $PeriodoInicio = "";
	private $Prazo = 0;
	private $Protocolo = "";
	private $ValorParcela = "";
	private $ValorRepasse = null;
	private $ValorSolicitado = "";
	private $ValorTotalExtra = null;
	private $KeyField = "PK_Averbado";
	private $Engine = "InnoDB";

	public function setPK_Averbado($PK_Averbado){
		$this->PK_Averbado = intval($PK_Averbado);
	}

	public function setFK_Reserva($FK_Reserva){
		if(is_null($FK_Reserva)) throw new Exception("Valor Nulo Inválido no campo [FK_Reserva]");
		if(!is_int($FK_Reserva)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Reserva]");
		$this->FK_Reserva = intval($FK_Reserva);
	}

	public function setFK_ConvenioUsuario($FK_ConvenioUsuario){
		if(is_null($FK_ConvenioUsuario)) throw new Exception("Valor Nulo Inválido no campo [FK_ConvenioUsuario]");
		if(!is_int($FK_ConvenioUsuario)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_ConvenioUsuario]");
		$this->FK_ConvenioUsuario = intval($FK_ConvenioUsuario);
	}

	public function setFK_Movimento($FK_Movimento){
		if($FK_Movimento == "" || $FK_Movimento == false) $FK_Movimento= null;
		if(!is_int($FK_Movimento)  && !is_null($FK_Movimento)) throw new Exception("Apenas valores inteiros são validos no campo [FK_Movimento]");
		$this->FK_Movimento = intval($FK_Movimento);
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
		$this->CPF = $CPF;
	}

	public function setNumeroMatricula($NumeroMatricula){
		$this->NumeroMatricula = $NumeroMatricula;
	}

	public function setFatorUtilizado($FatorUtilizado){
		if(is_null($FatorUtilizado)) throw new Exception("Valor Nulo Inválido no campo [FatorUtilizado]");
		$this->FatorUtilizado = floatval($FatorUtilizado);
	}

	public function setPeriodoInicio($PeriodoInicio){
		if(is_null($PeriodoInicio)) throw new Exception("Valor Nulo Inválido no campo [PeriodoInicio]");
		if(!is_string($PeriodoInicio)) throw new Exception("Apenas texto é permitido no campo [PeriodoInicio]");
		$this->PeriodoInicio = $PeriodoInicio;
	}

	public function setPrazo($Prazo){
		if(is_null($Prazo)) throw new Exception("Valor Nulo Inválido no campo [Prazo]");
		if(!is_int($Prazo)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [Prazo]");
		$this->Prazo = intval($Prazo);
	}

	public function setProtocolo($Protocolo){
		if(is_null($Protocolo)) throw new Exception("Valor Nulo Inválido no campo [Protocolo]");
		if(!is_string($Protocolo)) throw new Exception("Apenas texto é permitido no campo [Protocolo]");
		$this->Protocolo = $Protocolo;
	}

	public function setValorParcela($ValorParcela){
		if(is_null($ValorParcela)) throw new Exception("Valor Nulo Inválido no campo [ValorParcela]");
		$this->ValorParcela = floatval($ValorParcela);
	}

	public function setValorRepasse($ValorRepasse){
		$this->ValorRepasse = floatval($ValorRepasse);
	}

	public function setValorSolicitado($ValorSolicitado){
		if(is_null($ValorSolicitado)) throw new Exception("Valor Nulo Inválido no campo [ValorSolicitado]");
		$this->ValorSolicitado = floatval($ValorSolicitado);
	}

	public function setValorTotalExtra($ValorTotalExtra){
		$this->ValorTotalExtra = floatval($ValorTotalExtra);
	}

	public function getPK_Averbado(){
		return intval($this->PK_Averbado);
	}

	public function getFK_Reserva(){
		return intval($this->FK_Reserva);
	}

	public function getFK_ConvenioUsuario(){
		return intval($this->FK_ConvenioUsuario);
	}

	public function getFK_Movimento(){
		return intval($this->FK_Movimento);
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

	public function getFatorUtilizado(){
		return floatval($this->FatorUtilizado);
	}

	public function getPeriodoInicio(){
		return $this->PeriodoInicio;
	}

	public function getPrazo(){
		return intval($this->Prazo);
	}

	public function getProtocolo(){
		return $this->Protocolo;
	}

	public function getValorParcela(){
		return floatval($this->ValorParcela);
	}

	public function getValorRepasse(){
		return floatval($this->ValorRepasse);
	}

	public function getValorSolicitado(){
		return floatval($this->ValorSolicitado);
	}

	public function getValorTotalExtra(){
		return floatval($this->ValorTotalExtra);
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>