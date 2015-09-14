<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_orgao.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/funcoes.php';

////Verifica a conexão ativa
checkSession();

$PK_Orgao = isset($_POST['PK_Orgao']) ? $_POST['PK_Orgao'] : false;
$Nome = isset($_POST['Nome']) ? $_POST['Nome'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	$tmp = null;	
	$orgao = new Tbl_orgao();
	if($PK_Orgao){
		$orgao->setPK_Orgao($PK_Orgao);
		$tmp = $dao->loadByField($orgao);
	}
	$orgao->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $orgao = $tmp;
	$orgao->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$orgao->setNome($Nome);
	$orgao = $dao->save($orgao);
	$response['Save'] = $orgao->getPK_Orgao();
	
	//Armazendo Log
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setFK_User((int) $FK_User);
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setOperacao( ($PK_Orgao ? 'UPDATE' : 'INSERT') );
	$log->setPagina(basename(__FILE__));
	$log->setPK_Registro((int) $orgao->getPK_Orgao());
	$msg = '';
	if($PK_Orgao){
		$msg = 'Antes: '.print_r((array) $tmp,true).'\n';
	}
	$msg.= 'Depois: '.print_r((array) $orgao,true);
	$log->setData($msg);
	$dao->save($log);
	//End Log
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>