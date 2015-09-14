<?php
require_once '../class/dao.class.php';
require_once '../class/funcoes.php';
require_once '../class/tbl_user.class.php';

////Verifica a conexão ativa
checkSession();

$dao = new DAO();

$pk_user = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : false;
$FK_Orgao = isset($_POST['FK_Orgao']) ? $_POST['FK_Orgao'] : false;
$Tipo = isset($_POST['TipoProcesso']) ? $_POST['TipoProcesso'] : false;

$user = $dao->loadByQuery("SELECT * FROM tbl_user WHERE PK_User = '$pk_user'", new Tbl_user());
if(!$user instanceof Tbl_user){
	die(json_encode(false));
}

$query = "SELECT PHPFILE FROM tbl_script WHERE FK_Orgao = '$FK_Orgao' AND Tipo = '$Tipo' ";
$row = $dao->loadByQuery($query, new stdClass());
if(!$row){
	die($query );	
}
die(json_encode($row));

?>