<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 13/04/2015 13:03:03
Baseado em : mysql.gs:3306/dbautomato 
*/
date_default_timezone_set('America/Sao_Paulo');
require_once 'sql.class.php';

class DAO{

	private $oSql = null;
	public function DAO($file=null){
		$this->oSql = new SQL($file);
	}

	public function begin_trans(){
		return $this->oSql->begin_trans();
	}
	
	public function commit_trans(){
		return $this->oSql->commit_trans();
	}
	
	public function rollback_trans(){
		return $this->oSql->rollback_trans();
	}
	
	public function save($obj, $updateDuplicate = false){
		$id = $this->oSql->save($obj,$updateDuplicate);
		$key = $obj->getKeyField();
		$metodo = call_user_func(array(&$obj, 'getKeyField'));
		call_user_func(array(&$obj,"set$metodo"), $id );
		return self::loadByField($obj);
	}

	public function delete($obj){
		return $this->oSql->delete($obj);
	}

	public function loadByField($obj){
		$v = $this->oSql->lista($obj);
		if(count($v)!=1) return false;
		return $v[0];
	}

	public function lista($obj){
		return $this->oSql->lista($obj);
	}
	
	public function listaFromQuery($query, $obj){
		if(is_array($obj)){
			return $this->oSql->lista2Array($query);
		}else{
			return $this->oSql->lista($obj, $query);
		}
	}
	
	 public function Query($query){
		return $this->oSql->Query($query);
	}
	
	public function loadByQuery($query, $obj){
		$v = $this->oSql->lista($obj, $query);
		if(count($v)!=1) return false;
		return $v[0];
	}

	public static function fFloat($value){
		return floatval(str_replace(array(".",","),array("","."), $value));
	}

    public static function fDate($value){
    	if( strpos($value,"/") > 0){ //Formatado como BR, transformando em US
        	$tmp = preg_split('/\//', $value);
            return $tmp[2]."-".$tmp[1]."-".$tmp[0];
		}
	}
	
}
?>