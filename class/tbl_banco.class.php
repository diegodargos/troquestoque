<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_banco{

	private $PK_Banco = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Nome = null;
	private $KeyField = "PK_Banco";
	private $Engine = "InnoDB";

	public function setPK_Banco($PK_Banco){
		$this->PK_Banco = intval($PK_Banco);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setNome($Nome){
		$this->Nome = $Nome;
	}

	public function getPK_Banco(){
		return intval($this->PK_Banco);
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