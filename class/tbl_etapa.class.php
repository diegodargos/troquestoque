<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_etapa{

	private $PK_Etapa = 0;
	private $FK_Fluxo = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Url = "";
	private $Method = "";
	private $Sequencia = "";
	private $Cookie = "";
	private $Descricao = null;
	private $KeyField = "PK_Etapa";
	private $Engine = "InnoDB";

	public function setPK_Etapa($PK_Etapa){
		$this->PK_Etapa = intval($PK_Etapa);
	}

	public function setFK_Fluxo($FK_Fluxo){
		if(is_null($FK_Fluxo)) throw new Exception("Valor Nulo Inválido no campo [FK_Fluxo]");
		if(!is_int($FK_Fluxo)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Fluxo]");
		$this->FK_Fluxo = intval($FK_Fluxo);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setUrl($Url){
		if(is_null($Url)) throw new Exception("Valor Nulo Inválido no campo [Url]");
		if(!is_string($Url)) throw new Exception("Apenas texto é permitido no campo [Url]");
		$this->Url = $Url;
	}

	public function setMethod($Method){
		if(is_null($Method)) throw new Exception("Valor Nulo Inválido no campo [Method]");
		if(!is_string($Method)) throw new Exception("Apenas texto é permitido no campo [Method]");
		$this->Method = $Method;
	}

	public function setSequencia($Sequencia){
		if(is_null($Sequencia)) throw new Exception("Valor Nulo Inválido no campo [Sequencia]");
		$this->Sequencia = $Sequencia;
	}

	public function setCookie($Cookie){
		if(is_null($Cookie)) throw new Exception("Valor Nulo Inválido no campo [Cookie]");
		$this->Cookie = $Cookie;
	}

	public function setDescricao($Descricao){
		$this->Descricao = $Descricao;
	}

	public function getPK_Etapa(){
		return intval($this->PK_Etapa);
	}

	public function getFK_Fluxo(){
		return intval($this->FK_Fluxo);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getUrl(){
		return $this->Url;
	}

	public function getMethod(){
		return $this->Method;
	}

	public function getSequencia(){
		return $this->Sequencia;
	}

	public function getCookie(){
		return $this->Cookie;
	}

	public function getDescricao(){
		return $this->Descricao;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>