<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_cada_cliente{

	private $PK_Cada_Cliente = 0;
	private $FK_Convenio = 0;
	private $DateTimeInsert = null;
	private $DateTimeUpdate = null;
	private $CPF = "";
	private $Nome = null;
	private $NomeMae = null;
	private $RG = null;
	private $KeyField = "PK_Cada_Cliente";
	private $Engine = "InnoDB";

	public function setPK_Cada_Cliente($PK_Cada_Cliente){
		$this->PK_Cada_Cliente = intval($PK_Cada_Cliente);
	}

	public function setFK_Convenio($FK_Convenio){
		if(is_null($FK_Convenio)) throw new Exception("Valor Nulo Inválido no campo [FK_Convenio]");
		if(!is_int($FK_Convenio)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Convenio]");
		$this->FK_Convenio = intval($FK_Convenio);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setDateTimeUpdate($DateTimeUpdate){
		$this->DateTimeUpdate = $DateTimeUpdate;
	}

	public function setCPF($CPF){
		if(is_null($CPF)) throw new Exception("Valor Nulo Inválido no campo [CPF]");
		if(!is_string($CPF)) throw new Exception("Apenas texto é permitido no campo [CPF]");
		$this->CPF = $CPF;
	}

	public function setNome($Nome){
		$this->Nome = $Nome;
	}

	public function setNomeMae($NomeMae){
		$this->NomeMae = $NomeMae;
	}

	public function setRG($RG){
		$this->RG = $RG;
	}

	public function getPK_Cada_Cliente(){
		return intval($this->PK_Cada_Cliente);
	}

	public function getFK_Convenio(){
		return intval($this->FK_Convenio);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getDateTimeUpdate(){
		return $this->DateTimeUpdate;
	}

	public function getCPF(){
		return $this->CPF;
	}

	public function getNome(){
		return $this->Nome;
	}

	public function getNomeMae(){
		return $this->NomeMae;
	}

	public function getRG(){
		return $this->RG;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>