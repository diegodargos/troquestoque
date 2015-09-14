<?php
require_once '../class/dao.class.php';
require_once '../class/tbl_user.class.php';

$dao = new DAO();

$tbl = isset($_POST['Table']) ? $_POST['Table'] : false;
$id = isset($_POST['ID']) ? $_POST['ID'] : false;
$pk_user = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : false;

$user = $dao->loadByQuery("SELECT * FROM tbl_user WHERE PK_User = '$pk_user'", new Tbl_user());
if(!$user instanceof Tbl_user){
	die(json_encode(false));
}
	
if($tbl == "convenio"){
	$query = "SELECT * FROM tbl_convenio WHERE PK_Convenio = '$id'";
}elseif($tbl == "banco"){
	$query = "SELECT * FROM tbl_banco WHERE PK_Banco = '$id'";
}elseif($tbl == "usuario"){
	$query = "SELECT * FROM tbl_user WHERE PK_User = '$id'";
}elseif($tbl == "orgao"){
	$query = "SELECT * FROM tbl_orgao WHERE PK_Orgao = '$id'";
}elseif($tbl == "sistema"){
	$query = "SELECT * FROM tbl_sistema WHERE PK_Sistema = '$id'";
}elseif($tbl == "movimento"){
	$query = "SELECT * FROM tbl_movimento WHERE PK_Movimento = '$id'";
}elseif($tbl == "usurio_convenio"){
	$query = "SELECT * FROM tbl_convenio_usuario WHERE PK_Convenio_Usuario = '$id'";
}elseif($tbl == "parametro_convenio"){
	$query = "SELECT * FROM tbl_convenio_parametro WHERE PK_Convenio_Parametro = '$id'";
}elseif($tbl == "script"){
	$query = "SELECT * FROM tbl_script WHERE PK_Script = '$id'";
}elseif($tbl == "OrgaoConvenio"){
	$query = "SELECT * FROM tbl_convenio WHERE PK_Convenio = '$id'";
}elseif($tbl == "movimento_averb"){
	$query = "SELECT a.*, b.FK_Orgao, a.CodigoBanco AS Banco, a.NumeroMatricula AS Matricula, 
	a.ValorSolicitado AS ValorContrato, Parcelas AS Prazo, CodigoAgencia AS Agencia, FORMAT(c.ValorParcela,2,'pt_BR') AS pValorParcela, 
	FORMAT(c.ValorSolicitado,2,'pt_BR') AS pValorSolicitado
	FROM tbl_averb_movimento a
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_averb_averbado c ON a.PK_Movimento= c.FK_Movimento AND c.Status = 'Ativo'  
	WHERE PK_Movimento = '$id'";
}
$rows = $dao->loadByQuery($query, new stdClass());
die(json_encode($rows));
?>