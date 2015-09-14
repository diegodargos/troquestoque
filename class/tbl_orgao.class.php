<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_orgao{

	private $PK_Orgao = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Nome = "";
	private $KeyField = "PK_Orgao";
	private $Engine = "InnoDB";

	public function setPK_Orgao($PK_Orgao){
		$this->PK_Orgao = intval($PK_Orgao);
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

	public function getPK_Orgao(){
		return intval($this->PK_Orgao);
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

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>