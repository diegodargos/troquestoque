<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_user_banco{

	private $PK_UserBanco = 0;
	private $FK_User = 0;
	private $FK_Banco = 0;
	private $DateTimeInsert = null;
	private $KeyField = "PK_UserBanco";
	private $Engine = "InnoDB";

	public function setPK_UserBanco($PK_UserBanco){
		$this->PK_UserBanco = intval($PK_UserBanco);
	}

	public function setFK_User($FK_User){
		if(is_null($FK_User)) throw new Exception("Valor Nulo Inválido no campo [FK_User]");
		if(!is_int($FK_User)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_User]");
		$this->FK_User = intval($FK_User);
	}

	public function setFK_Banco($FK_Banco){
		if(is_null($FK_Banco)) throw new Exception("Valor Nulo Inválido no campo [FK_Banco]");
		if(!is_int($FK_Banco)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Banco]");
		$this->FK_Banco = intval($FK_Banco);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function getPK_UserBanco(){
		return intval($this->PK_UserBanco);
	}

	public function getFK_User(){
		return intval($this->FK_User);
	}

	public function getFK_Banco(){
		return intval($this->FK_Banco);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>