<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_sistema{

	private $PK_Sistema = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Nome = "";
	private $WebSite = "";
	private $KeyField = "PK_Sistema";
	private $Engine = "InnoDB";

	public function setPK_Sistema($PK_Sistema){
		$this->PK_Sistema = intval($PK_Sistema);
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

	public function setWebSite($WebSite){
		if(is_null($WebSite)) throw new Exception("Valor Nulo Inválido no campo [WebSite]");
		if(!is_string($WebSite)) throw new Exception("Apenas texto é permitido no campo [WebSite]");
		$this->WebSite = $WebSite;
	}

	public function getPK_Sistema(){
		return intval($this->PK_Sistema);
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

	public function getWebSite(){
		return $this->WebSite;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>