<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 09/03/2015 19:22:39
Baseado em : mysql.gs:3306/dbautomato 
*/

class Tbl_cada_cliente_vinculado{

	private $PK_ClienteVinculado = 0;
	private $FK_Cliente = 0;
	private $CPF_Origem = "";
	private $CPF_Vinculado = "";
	private $Nome = "";
	private $Vinculado = "";
	private $KeyField = "PK_ClienteVinculado";
	private $Engine = "InnoDB";

	public function setPK_ClienteVinculado($PK_ClienteVinculado){
		$this->PK_ClienteVinculado = $PK_ClienteVinculado;
	}

	public function setFK_Cliente($FK_Cliente){
		if(is_null($FK_Cliente)) throw new Exception("Valor Nulo Inválido no campo [FK_Cliente]");
		if(!is_int($FK_Cliente)) throw new Exception("Apenas valores inteiros nao nulos sao validos no campo [FK_Cliente]");
		$this->FK_Cliente = intval($FK_Cliente);
	}

	public function setCPF_Origem($CPF_Origem){
		if(is_null($CPF_Origem)) throw new Exception("Valor Nulo Inválido no campo [CPF_Origem]");
		if(!is_string($CPF_Origem)) throw new Exception("Apenas texto é permitido no campo [CPF_Origem]");
		$this->CPF_Origem = $CPF_Origem;
	}

	public function setCPF_Vinculado($CPF_Vinculado){
		if(is_null($CPF_Vinculado)) throw new Exception("Valor Nulo Inválido no campo [CPF_Vinculado]");
		if(!is_string($CPF_Vinculado)) throw new Exception("Apenas texto é permitido no campo [CPF_Vinculado]");
		$this->CPF_Vinculado = $CPF_Vinculado;
	}

	public function setNome($Nome){
		if(is_null($Nome)) throw new Exception("Valor Nulo Inválido no campo [Nome]");
		if(!is_string($Nome)) throw new Exception("Apenas texto é permitido no campo [Nome]");
		$this->Nome = $Nome;
	}

	public function setVinculado($Vinculado){
		if(is_null($Vinculado)) throw new Exception("Valor Nulo Inválido no campo [Vinculado]");
		$this->Vinculado = $Vinculado;
	}

	public function getPK_ClienteVinculado(){
		return intval($this->PK_ClienteVinculado);
	}

	public function getFK_Cliente(){
		return intval($this->FK_Cliente);
	}

	public function getCPF_Origem(){
		return $this->CPF_Origem;
	}

	public function getCPF_Vinculado(){
		return $this->CPF_Vinculado;
	}

	public function getNome(){
		return $this->Nome;
	}

	public function getVinculado(){
		return $this->Vinculado;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>