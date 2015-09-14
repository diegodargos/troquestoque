<?php
require_once '../class/dao.class.php';
require_once '../class/tbl_user.class.php';

$dao = new DAO();

$tbl = isset($_POST['Table']) ? $_POST['Table'] : false;
$pk_user = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : false;

$user = $dao->loadByQuery("SELECT * FROM tbl_user WHERE PK_User = '$pk_user'", new Tbl_user());
if(!$user instanceof Tbl_user){
	die(json_encode(false));
}
	
if($tbl == "convenio"){
	$query = "SELECT a.*, b.Nome AS Banco, c.Nome as Sistema, d.Nome as Orgao, 
	FORMAT(ValorMinimo,2,'pt_BR') AS ValorMinimo, FORMAT(ValorMaximo,2,'pt_BR') AS ValorMaximo 
	FROM tbl_convenio a 
	LEFT JOIN tbl_banco b ON b.PK_Banco = a.FK_Banco
	LEFT JOIN tbl_sistema c ON c.PK_Sistema = a.FK_Sistema
	LEFT JOIN tbl_orgao d ON d.PK_Orgao = a.FK_Orgao ";
	if($user->getAdmin() == 0 && $user->getRoot() == 0){
		$query .= "WHERE PK_Convenio = '{$user->getFK_Convenio()}'";
	}
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "banco"){
	$query = "SELECT a.* FROM tbl_banco a ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "orgao"){
	$query = "SELECT a.* FROM tbl_orgao a ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "sistema"){
	$query = "SELECT a.* FROM tbl_sistema a ";
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "usuario"){
	$query = "SELECT PK_User, CPF, a.Nome, Login, Email, IF(Root=1,'X','') AS Root, IF(Admin=1,'X','') AS Admin FROM tbl_user a LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio ";
	if($user->getAdmin() == 0 && $user->getRoot() == 0){
		$query .= "WHERE b.PK_Convenio = '{$user->getFK_Convenio()}'";
	}
	$rows = $dao->listaFromQuery($query, new stdClass());
}elseif($tbl == "importacao"){
	$query = "SELECT DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS DataImportacao, c.Nome AS Convenio,
	PK_Importacao, b.Login AS Usuario, a.NomeArquivo, CheckSum,
	CONCAT(PK_Importacao,'.',SUBSTRING_INDEX(NomeArquivo,'.',-1)) AS Arquivo,
	(SELECT COUNT(*) FROM tbl_log_importacao_data WHERE FK_Importacao = PK_Importacao) AS Registros
	FROM tbl_log_importacao a
	LEFT JOIN tbl_user b ON a.FK_User = b.PK_User
	LEFT JOIN tbl_convenio c ON c.PK_Convenio = a.FK_Convenio ";
	if($user->getAdmin() == 0 && $user->getRoot() == 0){
		$query .= "WHERE a.FK_Convenio = '{$user->getFK_Convenio()}' ";
	}
	$query .= "ORDER BY a.DateTimeUpdate DESC";
	$rows = $dao->listaFromQuery($query, new stdClass());
	
}elseif($tbl == "movimento"){
	$rows = array();
}elseif($tbl == "parametro_convenio"){
	$rows = array();
}elseif($tbl == "script"){
	$query = "SELECT PK_Script, FK_Sistema, FK_Orgao, Descricao, PHPFILE, b.Nome AS Sistema,
	c.Nome AS Orgao, Tipo 
	FROM tbl_script a
	LEFT JOIN tbl_sistema b ON a.FK_Sistema = b.PK_Sistema
	LEFT JOIN tbl_orgao c ON a.FK_Orgao = c.PK_Orgao";
	$rows = $dao->listaFromQuery($query, new stdClass());
}
die(json_encode($rows));
?>