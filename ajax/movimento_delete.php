<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_movimento.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/funcoes.php';

////Verifica a conexão ativa
checkSession();

$PK_Movimento = isset($_POST['PK']) ? $_POST['PK'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();
try{
	$tmp = null;	
	$movimento = new Tbl_movimento();
	if($PK_Movimento){
		$movimento->setPK_Movimento($PK_Movimento);
		$movimento = $dao->loadByField($movimento);
		$movimento instanceof Tbl_movimento;
		if($movimento->getValorInadimplente() == $movimento->getValorInadimplenteAtual()){			
			$dao->delete($movimento);
			//Armazendo Log
			$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
			$log = new Tbl_log();
			$log->setDateTimeInsert(date("Y-m-d H:i:s"));
			$log->setFK_User((int) $FK_User);
			$log->setIP($_SERVER['REMOTE_ADDR']);
			$log->setOperacao('DELETE');
			$log->setPagina(basename(__FILE__));
			$log->setPK_Registro((int) $PK_Movimento);
			$msg = 'Registro removido\n'.print_r((array) $movimento,true);
			$log->setData($msg);
			$dao->save($log);
			//End Log
		}else{
			$response['Erro'] = 'Movimento com registro de averbacao';
			
			//Armazendo Log
			$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
			$log = new Tbl_log();
			$log->setDateTimeInsert(date("Y-m-d H:i:s"));
			$log->setFK_User((int) $FK_User);
			$log->setIP($_SERVER['REMOTE_ADDR']);
			$log->setOperacao('DELETE');
			$log->setPagina(basename(__FILE__));
			$log->setPK_Registro((int) $PK_Movimento);
			$msg = 'Erro ao remover - movimento com averbacao \n'.print_r((array) $movimento,true);
			$log->setData($msg);
			$dao->save($log);
			//End Log
			
			die(json_encode($response));
		}
	}
	$response['Save'] = true;
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}

?>