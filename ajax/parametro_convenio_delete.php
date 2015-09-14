<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_convenio_parametro.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/funcoes.php';

////Verifica a conexão ativa
checkSession();

$PK_Convenio_Parametro = isset($_POST['PK']) ? (int) $_POST['PK'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();
try{
	$tmp = null;
	$convenio_parametro = new Tbl_convenio_parametro();
	if($PK_Convenio_Parametro){
		$convenio_parametro->setPK_Convenio_Parametro($PK_Convenio_Parametro);
		$convenio_parametro = $dao->loadByField($convenio_parametro);
		$dao->delete($convenio_parametro);

		//Armazendo Log
		$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
		$log = new Tbl_log();
		$log->setDateTimeInsert(date("Y-m-d H:i:s"));
		$log->setFK_User((int) $FK_User);
		$log->setIP($_SERVER['REMOTE_ADDR']);
		$log->setOperacao('DELETE');
		$log->setPagina(basename(__FILE__));
		$log->setPK_Registro((int) $PK_Convenio_Parametro);
		$msg = 'Registro removido\n'.print_r((array) $convenio_parametro,true);
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