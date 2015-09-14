<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_script{

	private $PK_Script = 0;
	private $FK_Sistema = 0;
	private $FK_Orgao = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Descricao = null;
	private $PHPFILE = "";
	private $Tipo = "";
	private $KeyField = "PK_Script";
	private $Engine = "InnoDB";

	public function setPK_Script($PK_Script){
		$this->PK_Script = intval($PK_Script);
	}

	public function setFK_Sistema($FK_Sistema){
		if(is_null($FK_Sistema)) throw new Exception("Valor Nulo Inválido no campo [FK_Sistema]");
		if(!is_int($FK_Sistema)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Sistema]");
		$this->FK_Sistema = intval($FK_Sistema);
	}

	public function setFK_Orgao($FK_Orgao){
		if(is_null($FK_Orgao)) throw new Exception("Valor Nulo Inválido no campo [FK_Orgao]");
		if(!is_int($FK_Orgao)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Orgao]");
		$this->FK_Orgao = intval($FK_Orgao);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setDescricao($Descricao){
		$this->Descricao = $Descricao;
	}

	public function setPHPFILE($PHPFILE){
		if(is_null($PHPFILE)) throw new Exception("Valor Nulo Inválido no campo [PHPFILE]");
		if(!is_string($PHPFILE)) throw new Exception("Apenas texto é permitido no campo [PHPFILE]");
		$this->PHPFILE = $PHPFILE;
	}

	public function setTipo($Tipo){
		if(is_null($Tipo)) throw new Exception("Valor Nulo Inválido no campo [Tipo]");
		if(!is_string($Tipo)) throw new Exception("Apenas texto é permitido no campo [Tipo]");
		$this->Tipo = $Tipo;
	}

	public function getPK_Script(){
		return intval($this->PK_Script);
	}

	public function getFK_Sistema(){
		return intval($this->FK_Sistema);
	}

	public function getFK_Orgao(){
		return intval($this->FK_Orgao);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getDescricao(){
		return $this->Descricao;
	}

	public function getPHPFILE(){
		return $this->PHPFILE;
	}

	public function getTipo(){
		return $this->Tipo;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>