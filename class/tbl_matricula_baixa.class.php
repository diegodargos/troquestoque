<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_matricula_baixa{

	private $PK_Matricula_Baixa = 0;
	private $FK_Matricula = 0;
	private $FK_Cliente = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $CodigoSolicitacao = "";
	private $DataSolicitacao = null;
	private $DataAutorizacao = null;
	private $DataBaixa = null;
	private $Evento = null;
	private $ValorParcela = "";
	private $Parcelas = 0;
	private $ParcelasDescontadas = 0;
	private $Observacao = null;
	private $UsuarioBaixa = null;
	private $UsuarioSolicitacao = null;
	private $UsuarioAverbacao = null;
	private $KeyField = "PK_Matricula_Baixa";
	private $Engine = "InnoDB";

	public function setPK_Matricula_Baixa($PK_Matricula_Baixa){
		$this->PK_Matricula_Baixa = intval($PK_Matricula_Baixa);
	}

	public function setFK_Matricula($FK_Matricula){
		if(is_null($FK_Matricula)) throw new Exception("Valor Nulo Inválido no campo [FK_Matricula]");
		if(!is_int($FK_Matricula)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Matricula]");
		$this->FK_Matricula = intval($FK_Matricula);
	}

	public function setFK_Cliente($FK_Cliente){
		if(is_null($FK_Cliente)) throw new Exception("Valor Nulo Inválido no campo [FK_Cliente]");
		if(!is_int($FK_Cliente)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Cliente]");
		$this->FK_Cliente = intval($FK_Cliente);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setCodigoSolicitacao($CodigoSolicitacao){
		if(is_null($CodigoSolicitacao)) throw new Exception("Valor Nulo Inválido no campo [CodigoSolicitacao]");
		if(!is_string($CodigoSolicitacao)) throw new Exception("Apenas texto é permitido no campo [CodigoSolicitacao]");
		$this->CodigoSolicitacao = $CodigoSolicitacao;
	}

	public function setDataSolicitacao($DataSolicitacao){
		$this->DataSolicitacao = $DataSolicitacao;
	}

	public function setDataAutorizacao($DataAutorizacao){
		$this->DataAutorizacao = $DataAutorizacao;
	}

	public function setDataBaixa($DataBaixa){
		$this->DataBaixa = $DataBaixa;
	}

	public function setEvento($Evento){
		$this->Evento = $Evento;
	}

	public function setValorParcela($ValorParcela){
		if(is_null($ValorParcela)) throw new Exception("Valor Nulo Inválido no campo [ValorParcela]");
		$this->ValorParcela = floatval($ValorParcela);
	}

	public function setParcelas($Parcelas){
		if(is_null($Parcelas)) throw new Exception("Valor Nulo Inválido no campo [Parcelas]");
		if(!is_int($Parcelas)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [Parcelas]");
		$this->Parcelas = intval($Parcelas);
	}

	public function setParcelasDescontadas($ParcelasDescontadas){
		if(is_null($ParcelasDescontadas)) throw new Exception("Valor Nulo Inválido no campo [ParcelasDescontadas]");
		if(!is_int($ParcelasDescontadas)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [ParcelasDescontadas]");
		$this->ParcelasDescontadas = intval($ParcelasDescontadas);
	}

	public function setObservacao($Observacao){
		$this->Observacao = $Observacao;
	}

	public function setUsuarioBaixa($UsuarioBaixa){
		if($UsuarioBaixa == "" || $UsuarioBaixa == false) $UsuarioBaixa= null;
		if(!is_int($UsuarioBaixa)  && !is_null($UsuarioBaixa)) throw new Exception("Apenas valores inteiros são validos no campo [UsuarioBaixa]");
		$this->UsuarioBaixa = intval($UsuarioBaixa);
	}

	public function setUsuarioSolicitacao($UsuarioSolicitacao){
		if($UsuarioSolicitacao == "" || $UsuarioSolicitacao == false) $UsuarioSolicitacao= null;
		if(!is_int($UsuarioSolicitacao)  && !is_null($UsuarioSolicitacao)) throw new Exception("Apenas valores inteiros são validos no campo [UsuarioSolicitacao]");
		$this->UsuarioSolicitacao = intval($UsuarioSolicitacao);
	}

	public function setUsuarioAverbacao($UsuarioAverbacao){
		if($UsuarioAverbacao == "" || $UsuarioAverbacao == false) $UsuarioAverbacao= null;
		if(!is_int($UsuarioAverbacao)  && !is_null($UsuarioAverbacao)) throw new Exception("Apenas valores inteiros são validos no campo [UsuarioAverbacao]");
		$this->UsuarioAverbacao = intval($UsuarioAverbacao);
	}

	public function getPK_Matricula_Baixa(){
		return intval($this->PK_Matricula_Baixa);
	}

	public function getFK_Matricula(){
		return intval($this->FK_Matricula);
	}

	public function getFK_Cliente(){
		return intval($this->FK_Cliente);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getCodigoSolicitacao(){
		return $this->CodigoSolicitacao;
	}

	public function getDataSolicitacao(){
		return $this->DataSolicitacao;
	}

	public function getDataAutorizacao(){
		return $this->DataAutorizacao;
	}

	public function getDataBaixa(){
		return $this->DataBaixa;
	}

	public function getEvento(){
		return $this->Evento;
	}

	public function getValorParcela(){
		return floatval($this->ValorParcela);
	}

	public function getParcelas(){
		return intval($this->Parcelas);
	}

	public function getParcelasDescontadas(){
		return intval($this->ParcelasDescontadas);
	}

	public function getObservacao(){
		return $this->Observacao;
	}

	public function getUsuarioBaixa(){
		return intval($this->UsuarioBaixa);
	}

	public function getUsuarioSolicitacao(){
		return intval($this->UsuarioSolicitacao);
	}

	public function getUsuarioAverbacao(){
		return intval($this->UsuarioAverbacao);
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>