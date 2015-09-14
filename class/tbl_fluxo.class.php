<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_fluxo{

	private $PK_Fluxo = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Nome = "";
	private $KeyField = "PK_Fluxo";
	private $Engine = "InnoDB";

	public function setPK_Fluxo($PK_Fluxo){
		$this->PK_Fluxo = intval($PK_Fluxo);
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

	public function getPK_Fluxo(){
		return intval($this->PK_Fluxo);
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