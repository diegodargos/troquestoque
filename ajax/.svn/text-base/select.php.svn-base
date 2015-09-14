<?php
require_once '../class/dao.class.php';
require_once '../class/funcoes.php';
require_once '../class/tbl_user.class.php';

////Verifica a conexão ativa
checkSession();

$dao = new DAO();

$tbl = isset($_POST['Table']) ? $_POST['Table'] : false;
$Filter = isset($_POST['Filter']) ? $_POST['Filter'] : false;
$pk_user = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : false;

$user = $dao->loadByQuery("SELECT * FROM tbl_user WHERE PK_User = '$pk_user'", new Tbl_user());
if(!$user instanceof Tbl_user){
	die(json_encode(false));	
}
$rows = array();
if($tbl == "banco"){
	$query = "SELECT PK_Banco AS Value, a.Nome AS Text FROM tbl_banco a WHERE 1=1";
	$bancos = $dao->listaFromQuery("SELECT FK_Banco FROM tbl_user_banco WHERE FK_User = '{$user->getPK_User()}' ", new stdClass());
	$dados = array();
	foreach($bancos as $banco){
		$dados[] = $banco->FK_Banco;
	}
	if(!empty($bancos)) $query.= " AND ( PK_Banco = '".implode("' OR PK_Banco = '", $dados)."' ) ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "convenio"){
	$query = "SELECT PK_Convenio AS Value, Nome AS Text FROM tbl_convenio WHERE TipoProcesso = 'rec' ";
	if(!is_bool($Filter)) $query.= "AND FK_Banco = '$Filter' ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "convenio_cartao"){
	$query = "SELECT PK_Convenio AS Value, Nome AS Text FROM tbl_convenio WHERE TipoProcesso = 'cartao' ";
	if(!is_bool($Filter)) $query.= "AND FK_Banco = '$Filter' ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "cons_margem"){
	$query = "SELECT PK_Convenio AS Value, Nome AS Text, Processo AS Processo FROM tbl_convenio WHERE TipoProcesso = 'cons' ";
	if(!is_bool($Filter)) $query.= "AND FK_Banco = '$Filter' ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "convenio_averb"){
	$query = "SELECT PK_Convenio AS Value, Nome AS Text, Processo AS Processo FROM tbl_convenio WHERE TipoProcesso = 'averb' ";
	if(!is_bool($Filter)) $query.= "AND FK_Banco = '$Filter' ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "sistema"){
	$query = "SELECT PK_Sistema AS Value, Nome AS Text FROM tbl_sistema ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "orgao"){
	$query = "SELECT PK_Orgao AS Value, Nome AS Text FROM tbl_orgao ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "vinculo"){
	$query = "SELECT DISTINCT IFNULL(Vinculo,'') AS Value, IFNULL(Vinculo,'') AS Text 
	FROM tbl_cliente_matricula a
	LEFT JOIN tbl_cada_cliente b ON b.PK_Cada_Cliente = a.FK_Cliente WHERE 1=1 ";
	if($Filter) $query.= "AND b.FK_Convenio = '$Filter' ";
	$query .= "ORDER BY Vinculo";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "instituicao"){
	$query = "SELECT DISTINCT IFNULL(Instituicao,'') AS Value, IFNULL(Instituicao,'') AS Text FROM tbl_cliente_matricula a
	LEFT JOIN tbl_cada_cliente b ON b.PK_Cada_Cliente = a.FK_Cliente WHERE 1=1 ";
	if($Filter) $query.= "AND b.FK_Convenio = '$Filter' ";
	$query .= "ORDER BY Instituicao";
	$rows = $dao->listaFromQuery($query, new stdClass());
}
die(json_encode($rows));

?>