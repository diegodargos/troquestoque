<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_convenio_usuario.class.php';
require_once '../class/funcoes.php';

$Ativo = isset($_POST['Ativo']) ? true : false;
$Expira = isset($_POST['Expira']) ? true : false;
$FK_Convenio = isset($_POST['FK_Convenio']) ? (int) $_POST['FK_Convenio'] : false;
$PK_Convenio_Usuario = isset($_POST['PK_Convenio_Usuario']) ? (int) $_POST['PK_Convenio_Usuario'] : false;
$Senha = isset($_POST['Senha']) ? $_POST['Senha'] : false;
$Usuario = isset($_POST['Usuario']) ? $_POST['Usuario'] : false;
$Validade = isset($_POST['Validade']) ? $_POST['Validade'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	$tmp = null;	
	$usuario = new Tbl_convenio_usuario();
	if($PK_Convenio_Usuario){
		$usuario->setPK_Convenio_Usuario($PK_Convenio_Usuario);
		$tmp = $dao->loadByField($usuario);
	}
	$usuario->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $usuario = $tmp;
	$usuario->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$usuario->setAtivo($Ativo);
	$usuario->setExpira($Expira);
	$usuario->setFK_Convenio($FK_Convenio);
	$usuario->setSenha($Senha);
	$usuario->setUsuario($Usuario);
	$usuario->setValidade($Validade == "" ? null : $dao::fDate($Validade));
	$usuario = $dao->save($usuario);
	$response['Save'] = $usuario->getPK_Convenio_Usuario();
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>