<?php
class CSV{

	private $cabecalho = array();
	private $dados = array();
	private $registros = array();
	
	public function setCabecalho($cabecalho){
		if(!is_array($cabecalho)) throw new Exception("Vetor de Cabe�alho Esperado ".gettype($cabecalho)." informado" );
		$this->cabecalho = $cabecalho;
	}

	public function setCCData($dados){
		if(!is_array($dados)) throw new Exception("Vetor de Dados Esperado");
		$this->dados = $dados;
	}
	
	public function setDados($dados){
		if(!is_array($dados)) throw new Exception("Vetor de Dados Esperado");
		$this->registros = $dados;
	}
	
	public function save($filename=null){
		$csvFile = "";
		foreach ($this->cabecalho as $dado){
			$csvFile.= utf8_decode(trim($dado)).';';
		}
		$csvFile.= "\n";
		foreach ($this->dados as $dado){
			foreach($this->registros as $registro){
				$csvFile.='"'.trim(utf8_decode($dado->{$registro})).'";';
			}
			$csvFile.= "\n";
		}
		
		if($filename) file_put_contents($filename, $csvFile);
		else return $csvFile;
	}
	
}

?>