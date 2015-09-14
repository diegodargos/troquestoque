<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_parametro{

	private $PK_Parametro = 0;
	private $FK_Etapa = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Varname = "";
	private $CssSelector = null;
	private $Attribute = "";
	private $Type = "";
	private $Method = "";
	private $KeyField = "PK_Parametro";
	private $Engine = "InnoDB";

	public function setPK_Parametro($PK_Parametro){
		$this->PK_Parametro = intval($PK_Parametro);
	}

	public function setFK_Etapa($FK_Etapa){
		if(is_null($FK_Etapa)) throw new Exception("Valor Nulo Inválido no campo [FK_Etapa]");
		if(!is_int($FK_Etapa)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Etapa]");
		$this->FK_Etapa = intval($FK_Etapa);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setVarname($Varname){
		if(is_null($Varname)) throw new Exception("Valor Nulo Inválido no campo [Varname]");
		if(!is_string($Varname)) throw new Exception("Apenas texto é permitido no campo [Varname]");
		$this->Varname = $Varname;
	}

	public function setCssSelector($CssSelector){
		$this->CssSelector = $CssSelector;
	}

	public function setAttribute($Attribute){
		if(is_null($Attribute)) throw new Exception("Valor Nulo Inválido no campo [Attribute]");
		if(!is_string($Attribute)) throw new Exception("Apenas texto é permitido no campo [Attribute]");
		$this->Attribute = $Attribute;
	}

	public function setType($Type){
		if(is_null($Type)) throw new Exception("Valor Nulo Inválido no campo [Type]");
		if(!is_string($Type)) throw new Exception("Apenas texto é permitido no campo [Type]");
		$this->Type = $Type;
	}

	public function setMethod($Method){
		if(is_null($Method)) throw new Exception("Valor Nulo Inválido no campo [Method]");
		if(!is_string($Method)) throw new Exception("Apenas texto é permitido no campo [Method]");
		$this->Method = $Method;
	}

	public function getPK_Parametro(){
		return intval($this->PK_Parametro);
	}

	public function getFK_Etapa(){
		return intval($this->FK_Etapa);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getVarname(){
		return $this->Varname;
	}

	public function getCssSelector(){
		return $this->CssSelector;
	}

	public function getAttribute(){
		return $this->Attribute;
	}

	public function getType(){
		return $this->Type;
	}

	public function getMethod(){
		return $this->Method;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>