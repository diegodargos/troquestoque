<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 02/06/2015 11:05:56
Baseado em : mysql.gs:3306/dbsysconsigna 
*/

class Tbl_log_cpf_invalido{

	private $PK_CPFInvalido = 0;
	private $FK_Movimento = null;
	private $DateTimeInsert = null;
	private $MatriculaConsulta = null;
	private $CPF = null;
	private $MatriculaLocalizada = null;
	private $NomeLocalizado = null;
	private $KeyField = "PK_CPFInvalido";
	private $Engine = "InnoDB";

	public function setPK_CPFInvalido($PK_CPFInvalido){
		$this->PK_CPFInvalido = intval($PK_CPFInvalido);
	}

	public function setFK_Movimento($FK_Movimento){
		if($FK_Movimento == "" || $FK_Movimento == false) $FK_Movimento= null;
		if(!is_int($FK_Movimento)  && !is_null($FK_Movimento)) throw new Exception("Apenas valores inteiros são validos no campo [FK_Movimento]");
		$this->FK_Movimento = intval($FK_Movimento);
	}

	public function setDateTimeInsert($DateTimeInsert){
		$this->DateTimeInsert = $DateTimeInsert;
	}

	public function setMatriculaConsulta($MatriculaConsulta){
		$this->MatriculaConsulta = $MatriculaConsulta;
	}

	public function setCPF($CPF){
		$this->CPF = $CPF;
	}

	public function setMatriculaLocalizada($MatriculaLocalizada){
		$this->MatriculaLocalizada = $MatriculaLocalizada;
	}

	public function setNomeLocalizado($NomeLocalizado){
		$this->NomeLocalizado = $NomeLocalizado;
	}

	public function getPK_CPFInvalido(){
		return intval($this->PK_CPFInvalido);
	}

	public function getFK_Movimento(){
		return intval($this->FK_Movimento);
	}

	public function getDateTimeInsert(){
		return $this->DateTimeInsert;
	}

	public function getMatriculaConsulta(){
		return $this->MatriculaConsulta;
	}

	public function getCPF(){
		return $this->CPF;
	}

	public function getMatriculaLocalizada(){
		return $this->MatriculaLocalizada;
	}

	public function getNomeLocalizado(){
		return $this->NomeLocalizado;
	}

	public function getKeyField(){
		return $this->KeyField;
	}

}
?>