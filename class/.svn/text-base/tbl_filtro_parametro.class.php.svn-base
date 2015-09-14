<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_filtro_parametro{

	private $PK_Filtro = 0;
	private $FK_Parametro = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $Condicao = "";
	private $Sequencia = "";
	private $KeyField = "PK_Filtro";
	private $Engine = "InnoDB";

	public function setPK_Filtro($PK_Filtro){
		$this->PK_Filtro = intval($PK_Filtro);
	}

	public function setFK_Parametro($FK_Parametro){
		if(is_null($FK_Parametro)) throw new Exception("Valor Nulo Inválido no campo [FK_Parametro]");
		if(!is_int($FK_Parametro)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Parametro]");
		$this->FK_Parametro = intval($FK_Parametro);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setCondicao($Condicao){
		if(is_null($Condicao)) throw new Exception("Valor Nulo Inválido no campo [Condicao]");
		if(!is_string($Condicao)) throw new Exception("Apenas texto é permitido no campo [Condicao]");
		$this->Condicao = $Condicao;
	}

	public function setSequencia($Sequencia){
		if(is_null($Sequencia)) throw new Exception("Valor Nulo Inválido no campo [Sequencia]");
		$this->Sequencia = $Sequencia;
	}

	public function getPK_Filtro(){
		return intval($this->PK_Filtro);
	}

	public function getFK_Parametro(){
		return intval($this->FK_Parametro);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getCondicao(){
		return $this->Condicao;
	}

	public function getSequencia(){
		return $this->Sequencia;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>