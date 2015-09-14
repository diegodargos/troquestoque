<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 13/04/2015 13:03:03
Baseado em : mysql.gs:3306/dbautomato 
*/

require_once 'proprietes.class.php';

class sql{

	private $con = null;

	public function sql($file=null){
		$info = pathinfo(__FILE__);
		$posFinal = strlen( $info['dirname']) - strlen(strrchr($info['dirname'], "class"));
		$path = substr($info['dirname'], 0, $posFinal );
		if($file != null ){
			$oProperties = new Properties("$path/$file.prop");
		}else{
			$oProperties = new Properties("$path/dbautomato.prop");
		}
		$this->con = new mysqli($oProperties->get("SERVER"), $oProperties->get("USER",true), $oProperties->get("PASSWORD",true), $oProperties->get("DATABASE"), $oProperties->get("PORT"));
		if(mysqli_connect_error()) die("Erro<br>" . mysqli_connect_error());
	}

	public function getConnection(){
		return $this->con;
	}

	public function save($obj, $updateOnDuplicate = false){
		$id = call_user_func(array(&$obj,"get".$obj->getKeyField() ));
		$tmp = self::getAttrib($obj);
		if($id>0){
			$query = "UPDATE ". strtolower(get_class($obj)) . " SET ";
			for($c=0; $c < count($tmp["Fields"]); $c++ ){
				$query .= $tmp["Fields"][$c] .  " = " . ( is_null($tmp["Values"][$c]) ? "NULL" : "'" . $tmp["Values"][$c] . "'");
				if($c +1 < count($tmp["Fields"]) ) $query .= ", ";
			}
			$query .= " WHERE  " . $obj->getKeyField() . " = '$id'";
		}else{
			$campos = $tmp["Fields"];
			unset($campos[array_search($obj->getKeyField(), $tmp["Fields"])]);
			$query = "INSERT INTO " . strtolower(get_class($obj)) . " (" . implode(",", $campos) .") VALUES (";
			for($c=0; $c < count($tmp["Fields"]); $c++ ){
				if($tmp["Fields"][$c] != strtolower($obj->getKeyField())){
					$query .= ( is_null($tmp["Values"][$c]) ? "NULL" : "'" . $tmp["Values"][$c] . "'");
					if($c +1 < count($tmp["Fields"]) ) $query .= ", ";
				}
			}
			$query .= ") ";
			if($updateOnDuplicate){
				$query .= "ON DUPLICATE KEY UPDATE ";
				for($c=0; $c < count($tmp["Fields"]); $c++ ){
					if( $tmp["Fields"][$c] != strtolower($obj->getKeyField()) && strtolower($tmp["Fields"][$c]) != strtolower("datetimeinsert") ){
						$query .= $tmp["Fields"][$c] .  " = VALUES(" . $tmp["Fields"][$c] . ")";
						if($c+1 < count($tmp["Fields"]) ) $query .= ", ";
					}
				}	
			}
		}
		if(!$this->con->query($query) ) throw new Exception($this->con->error,$this->con->errno);
		return (int) ($id>0 ? $id : $this->con->insert_id);
	}

	public function delete($obj){
		$where = "";
		$query= "DELETE FROM ". strtolower(get_class($obj));
		$tmp = self::getAttrib($obj);
		foreach($tmp["SetValues"] as $field => $valor){
			if($where == "") $query.=" WHERE ";
			if($where != "" ) $where .= " AND ";
			$where .= "$field = '$valor'";
		}
		if(!$this->con->query($query . $where) ) throw new Exception($this->con->error,$this->con->errno);
		return true;
	}

	public function lista2Array($query = null){
		if(!$result = $this->con->query($query)) throw new Exception($this->con->error,$this->con->errno);
		$vDados = array();
		while($row = $result->fetch_array(1) ){
			$vDados[] = $row;
		}
		return $vDados;
	}

	public function lista($obj, $query = null){
		if(!$query){
			$tmp = self::getAttrib($obj);
			$query = " SELECT * FROM ". strtolower(get_class($obj));
			$c=0;
			$where = "";
			foreach($tmp['SetValues'] as $field => $value){
				if($c > 0) $where.= " AND ";
				$where.= "$field = '$value'";
				$c++;
			}
			if($where != "" ) $query.= " WHERE " . $where;
		}
		if(!$result = $this->con->query($query)) throw new Exception($this->con->error,$this->con->errno);
		$vObjs = array();
		while($row = $result->fetch_object(get_class($obj)) ){ 
			$vObjs[] = $row;
		}
		return $vObjs;
	}

	public function query($query){
		if(!$this->con->query($query) ) throw new Exception($this->con->error,$this->con->errno);
		return true;
	}
	
	public function begin_trans(){
		if( !mysqli_autocommit($this->con, false) ) return false;
		return true;
	}

	public function commit_trans(){
		if( !mysqli_commit($this->con) ) return false;
		return true;
	}
	
	public function rollback_trans(){
		if( !mysqli_rollback($this->con) ) return false;
		return true;
	}

	private function getAttrib($obj){
		$v = get_class_methods($obj);
		$vars = array();
		$values = array();
		$nameValues = array();
		$vars = array();
		foreach ($v as $item){
			if(substr($item,0,3) == "set"){
				$vars[] = strtolower(substr($item,3));
				$valor = call_user_func(array(&$obj, "get".substr($item,3))); // Chamada recursiva do object
				$values[] = $valor; 
				if($valor) $nameValues[strtolower(substr($item,3))] = $valor;
			}
		}
		return array("Fields"=>$vars,"Values"=>$values,"SetValues"=>$nameValues);
	}

}
?>