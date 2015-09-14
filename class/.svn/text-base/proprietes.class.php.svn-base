<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 13/04/2015 13:03:03
Baseado em : mysql.gs:3306/dbautomato 
*/
date_default_timezone_set('America/Sao_Paulo');
require_once 'crypto.class.php';

class Properties{
	
	private $filename = null;
	private $crypto = null;
	private $prop = array();
	
	public function Properties($filename){
		$this->filename = $filename;
		if(file_exists($this->filename)){
			$this->loadFromFile();
			$this->crypto = new Crypto();
		}else{
			throw new Exception("File ". $this->filename." not found",13);
			return false;
		}
	}
	
	private function loadFromFile(){
		$document = file_get_contents($this->filename);
		$linhas = preg_split("/\r\n/",$document);
		foreach ($linhas as $linha){
			if($linha != "" && substr($linha,0,1) != "#" ){
				$vars = preg_split("/=>/", $linha);
				if(count($vars) != 2) return "";
				self::set($vars[0], $vars[1]);
			}
		}
	}
	
	public function set($propertie, $value, $crypto = false){
		if($crypto) $value = $this->crypto->Encrypt($value);
		$this->prop[$propertie] = $value;
	}
	
	public function get($propertie, $decrypto = false){
		if(!isset($this->prop[$propertie])) return null;
		if($decrypto) return $this->crypto->Decrypt($this->prop[$propertie]);
		return $this->prop[$propertie];
	}
	
	public function save(){
		$document = "";
		foreach($this->prop as $campo => $valor){
			$document .= "$campo=>$valor\r\n";
		}
		if(!file_put_contents($this->filename, $document) ) return false;
		return true;
	}
	
}
?>