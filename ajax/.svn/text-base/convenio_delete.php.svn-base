<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_convenio.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/funcoes.php';

//Verifica a conexão ativa
checkSession();

$PK_Convenio = isset($_POST['PK']) ? $_POST['PK'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();
try{
	$tmp = null;	
	$convenio = new Tbl_convenio();
	if($PK_Convenio){
		$convenio->setPK_Convenio($PK_Convenio);
		$convenio = $dao->loadByField($convenio);
		$dao->delete($convenio);
		
		//Armazendo Log
		$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
		$log = new Tbl_log();
		$log->setDateTimeInsert(date("Y-m-d H:i:s"));
		$log->setFK_User((int) $FK_User);
		$log->setIP($_SERVER['REMOTE_ADDR']);
		$log->setOperacao('DELETE');
		$log->setPagina(basename(__FILE__));
		$log->setPK_Registro((int) $PK_Convenio);
		$msg = 'Registro removido\n'.print_r((array) $convenio,true);
		$log->setData($msg);
		$dao->save($log);
		//End Log
	}
	$response['Save'] = true;
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>