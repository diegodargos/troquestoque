<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/tbl_script.class.php';
require_once '../class/funcoes.php';

//Verifica a conexão ativa
checkSession();

$PK_Script = isset($_POST['PK_Script']) ? $_POST['PK_Script'] : false;
$FK_Sistema = isset($_POST['FK_Sistema']) ? $_POST['FK_Sistema'] : false;
$FK_Orgao = isset($_POST['FK_Orgao']) ? $_POST['FK_Orgao'] : false;
$Tipo = isset($_POST['Tipo']) ? $_POST['Tipo'] : false;
$Descricao = isset($_POST['Descricao']) ? $_POST['Descricao'] : false;
$PHPFILE = isset($_POST['PHPFILE']) ? $_POST['PHPFILE'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	$tmp = null;	
	$script = new Tbl_script();
	if($PK_Script){
		$script->setPK_Script($PK_Script);
		$tmp = $dao->loadByField($script);
	}
	$script->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $script = $tmp;
	$script->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$script->setDescricao($Descricao);
	$script->setFK_Orgao((int) $FK_Orgao);
	$script->setFK_Sistema((int) $FK_Sistema);
	$script->setTipo($Tipo);
	$script->setPHPFILE($PHPFILE);
	$script = $dao->save($script);
	$response['Save'] = $script->getPK_Script();
	
	//Armazendo Log
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setFK_User((int) $FK_User);
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setOperacao( ($PK_Script ? 'UPDATE' : 'INSERT') );
	$log->setPagina(basename(__FILE__));
	$log->setPK_Registro((int) $script->getPK_Script());
	$msg = '';
	if($PK_Script){
		$msg = 'Antes: '.print_r((array) $tmp,true).'\n';
	}
	$msg.= 'Depois: '.print_r((array) $script,true);
	$log->setData($msg);
	$dao->save($log);
	//End Log
	
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>