<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_averb_movimento.class.php';
require_once '../class/tbl_averb_log.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/util.class.php';
require_once '../class/funcoes.php';
//Verifica a conexão ativa
checkSession();

$PK_Movimento = isset($_POST['PK']) ? $_POST['PK'] : false;


$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{

	$movimento = new Tbl_averb_movimento();
	$movimento->setPK_Movimento((int) $PK_Movimento);
	$movimento = $dao->loadByField($movimento);
	if($movimento instanceof Tbl_averb_movimento){
		if($movimento->getStatus() == 'Parcial' || $movimento->getStatus() == 'Consulta'){
			$movimento->setDateTimeUpdate(date("Y-m-d H:i:s"));
			$movimento->setStatus('Encerrado');
			$movimento = $dao->save($movimento);
			//Registra Inclusão.
			$rec = new Tbl_averb_log();
			$rec->setDateTimeInsert(date("Y-m-d H:i:s"));
			$rec->setCPF($movimento->getCPF());
			$rec->setFK_Convenio((int) $movimento->getFK_Convenio());
			$rec->setFK_Movimento((int) $movimento->getPK_Movimento());
			$rec->setMatricula($movimento->getNumeroMatricula());
			$rec->setMensagem('Cancelamento de recorrencia realizado pelo login: '.$_COOKIE['user']);
			$dao->save($rec);
			
		}
	}
	//Armazendo Log
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setFK_User((int) $FK_User);
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setOperacao( ('INSERT') );
	$log->setPagina(basename(__FILE__));
	$log->setPK_Registro((int) $movimento->getPK_Movimento());
	$msg = '';
	$msg.= 'Depois: '.print_r((array) $movimento,true);
	$log->setData($msg);
	$dao->save($log);
	$response['Save'] = $movimento->getPK_Movimento();
	//End Log
	
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}

die(json_encode($response));
?>