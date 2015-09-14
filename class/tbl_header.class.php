<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_header{

	private $PK_Header = 0;
	private $FK_Etapa = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Nome = "";
	private $Valor = "";
	private $KeyField = "PK_Header";
	private $Engine = "InnoDB";

	public function setPK_Header($PK_Header){
		$this->PK_Header = intval($PK_Header);
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

	public function setNome($Nome){
		if(is_null($Nome)) throw new Exception("Valor Nulo Inválido no campo [Nome]");
		if(!is_string($Nome)) throw new Exception("Apenas texto é permitido no campo [Nome]");
		$this->Nome = $Nome;
	}

	public function setValor($Valor){
		if(is_null($Valor)) throw new Exception("Valor Nulo Inválido no campo [Valor]");
		if(!is_string($Valor)) throw new Exception("Apenas texto é permitido no campo [Valor]");
		$this->Valor = $Valor;
	}

	public function getPK_Header(){
		return intval($this->PK_Header);
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

	public function getNome(){
		return $this->Nome;
	}

	public function getValor(){
		return $this->Valor;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>