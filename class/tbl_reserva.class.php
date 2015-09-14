<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_reserva{

	private $PK_Reserva = 0;
	private $FK_Cliente = 0;
	private $FK_ClienteMatricula = 0;
	private $FK_Movimento = 0;
	private $DateTimeInsert = "";
	private $DateTimeUpdate = "";
	private $CPF = null;
	private $NumeroMatricula = null;
	private $Contrato = "";
	private $Protocolo = "";
	private $ValorSolicitado = "";
	private $ValorParcela = "";
	private $Prazo = 0;
	private $ValorBaseReserva = "";
	private $PeriodoInicio = "";
	private $ValorRepasse = null;
	private $ValorTotalExtra = null;
	private $FatorUtilizado = null;
	private $IP = "";
	private $Averbado = "";
	private $KeyField = "PK_Reserva";
	private $Engine = "InnoDB";

	public function setPK_Reserva($PK_Reserva){
		$this->PK_Reserva = intval($PK_Reserva);
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

	public function setFK_Movimento($FK_Movimento){
		if(is_null($FK_Movimento)) throw new Exception("Valor Nulo Inválido no campo [FK_Movimento]");
		if(!is_int($FK_Movimento)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Movimento]");
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

	public function setContrato($Contrato){
		if(is_null($Contrato)) throw new Exception("Valor Nulo Inválido no campo [Contrato]");
		if(!is_string($Contrato)) throw new Exception("Apenas texto é permitido no campo [Contrato]");
		$this->Contrato = $Contrato;
	}

	public function setProtocolo($Protocolo){
		if(is_null($Protocolo)) throw new Exception("Valor Nulo Inválido no campo [Protocolo]");
		if(!is_string($Protocolo)) throw new Exception("Apenas texto é permitido no campo [Protocolo]");
		$this->Protocolo = $Protocolo;
	}

	public function setValorSolicitado($ValorSolicitado){
		if(is_null($ValorSolicitado)) throw new Exception("Valor Nulo Inválido no campo [ValorSolicitado]");
		$this->ValorSolicitado = floatval($ValorSolicitado);
	}

	public function setValorParcela($ValorParcela){
		if(is_null($ValorParcela)) throw new Exception("Valor Nulo Inválido no campo [ValorParcela]");
		$this->ValorParcela = floatval($ValorParcela);
	}

	public function setPrazo($Prazo){
		if(is_null($Prazo)) throw new Exception("Valor Nulo Inválido no campo [Prazo]");
		if(!is_int($Prazo)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [Prazo]");
		$this->Prazo = intval($Prazo);
	}

	public function setValorBaseReserva($ValorBaseReserva){
		if(is_null($ValorBaseReserva)) throw new Exception("Valor Nulo Inválido no campo [ValorBaseReserva]");
		$this->ValorBaseReserva = floatval($ValorBaseReserva);
	}

	public function setPeriodoInicio($PeriodoInicio){
		if(is_null($PeriodoInicio)) throw new Exception("Valor Nulo Inválido no campo [PeriodoInicio]");
		if(!is_string($PeriodoInicio)) throw new Exception("Apenas texto é permitido no campo [PeriodoInicio]");
		$this->PeriodoInicio = $PeriodoInicio;
	}

	public function setValorRepasse($ValorRepasse){
		$this->ValorRepasse = floatval($ValorRepasse);
	}

	public function setValorTotalExtra($ValorTotalExtra){
		$this->ValorTotalExtra = floatval($ValorTotalExtra);
	}

	public function setFatorUtilizado($FatorUtilizado){
		$this->FatorUtilizado = floatval($FatorUtilizado);
	}

	public function setIP($IP){
		if(is_null($IP)) throw new Exception("Valor Nulo Inválido no campo [IP]");
		if(!is_string($IP)) throw new Exception("Apenas texto é permitido no campo [IP]");
		$this->IP = $IP;
	}

	public function setAverbado($Averbado){
		if(is_null($Averbado)) throw new Exception("Valor Nulo Inválido no campo [Averbado]");
		$this->Averbado = $Averbado;
	}

	public function getPK_Reserva(){
		return intval($this->PK_Reserva);
	}

	public function getFK_Cliente(){
		return intval($this->FK_Cliente);
	}

	public function getFK_ClienteMatricula(){
		return intval($this->FK_ClienteMatricula);
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

	public function getContrato(){
		return $this->Contrato;
	}

	public function getProtocolo(){
		return $this->Protocolo;
	}

	public function getValorSolicitado(){
		return floatval($this->ValorSolicitado);
	}

	public function getValorParcela(){
		return floatval($this->ValorParcela);
	}

	public function getPrazo(){
		return intval($this->Prazo);
	}

	public function getValorBaseReserva(){
		return floatval($this->ValorBaseReserva);
	}

	public function getPeriodoInicio(){
		return $this->PeriodoInicio;
	}

	public function getValorRepasse(){
		return floatval($this->ValorRepasse);
	}

	public function getValorTotalExtra(){
		return floatval($this->ValorTotalExtra);
	}

	public function getFatorUtilizado(){
		return floatval($this->FatorUtilizado);
	}

	public function getIP(){
		return $this->IP;
	}

	public function getAverbado(){
		return $this->Averbado;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>