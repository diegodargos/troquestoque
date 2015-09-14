<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_user_modulo{

	private $PK_User_Acesso = 0;
	private $FK_User = 0;
	private $Modulo = "";
	private $Liberado = "";
	private $KeyField = "PK_User_Acesso";
	private $Engine = "InnoDB";

	public function setPK_User_Acesso($PK_User_Acesso){
		$this->PK_User_Acesso = intval($PK_User_Acesso);
	}

	public function setFK_User($FK_User){
		if(is_null($FK_User)) throw new Exception("Valor Nulo Inválido no campo [FK_User]");
		if(!is_int($FK_User)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_User]");
		$this->FK_User = intval($FK_User);
	}

	public function setModulo($Modulo){
		if(is_null($Modulo)) throw new Exception("Valor Nulo Inválido no campo [Modulo]");
		if(!is_string($Modulo)) throw new Exception("Apenas texto é permitido no campo [Modulo]");
		$this->Modulo = $Modulo;
	}

	public function setLiberado($Liberado){
		if(is_null($Liberado)) throw new Exception("Valor Nulo Inválido no campo [Liberado]");
		$this->Liberado = $Liberado;
	}

	public function getPK_User_Acesso(){
		return intval($this->PK_User_Acesso);
	}

	public function getFK_User(){
		return intval($this->FK_User);
	}

	public function getModulo(){
		return $this->Modulo;
	}

	public function getLiberado(){
		return $this->Liberado;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>