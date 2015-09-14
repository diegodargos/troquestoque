<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_sistema.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/funcoes.php';

$PK_Sistema = isset($_POST['PK_Sistema']) ? $_POST['PK_Sistema'] : false;
$Nome = isset($_POST['Nome']) ? $_POST['Nome'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	$tmp = null;	
	$sistema = new Tbl_sistema();
	if($PK_Sistema){
		$sistema->setPK_Sistema((int) $PK_Sistema);
		$tmp = $dao->loadByField($sistema);
	}
	$sistema->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $sistema = $tmp;
	$sistema->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$sistema->setNome($Nome);
	$sistema = $dao->save($sistema);
	$response['Save'] = $sistema->getPK_Sistema();
	
	//Armazendo Log
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setFK_User((int) $FK_User);
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setOperacao( ($PK_Sistema ? 'UPDATE' : 'INSERT') );
	$log->setPagina(basename(__FILE__));
	$log->setPK_Registro((int) $sistema->getPK_Sistema());
	$msg = '';
	if($PK_Sistema){
		$msg = 'Antes: '.print_r((array) $tmp,true).'\n';
	}
	$msg.= 'Depois: '.print_r((array) $sistema,true);
	$log->setData($msg);
	$dao->save($log);
	//End Log
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>