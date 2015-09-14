<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_cartao_movimento.class.php';
require_once '../class/tbl_cartao_log.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/util.class.php';
require_once '../class/funcoes.php';
//Verifica a conexão ativa
checkSession();

$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
$FK_Convenio = isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
$CPF = isset($_POST['CPF']) ? $_POST['CPF'] : false;
$Matricula = isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
$NumeroContrato = isset($_POST['NumeroContrato']) ? $_POST['NumeroContrato'] : false;
$ValorContrato = isset($_POST['ValorSolicitado']) ? $_POST['ValorSolicitado'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	//Protecao contra duplicidade de movimento.
	$query = "SELECT * FROM tbl_cartao_movimento WHERE CPF = '$CPF' AND NumeroMatricula = '$Matricula' AND NumeroContrato = '$NumeroContrato' AND (Status = 'Averbado' OR Status = 'Parcial' OR Status = 'Consulta') ";
	$tmp = $dao->loadByQuery($query, new Tbl_cartao_movimento());
	if($tmp){
		$response['Erro'] = 'CPF: '.$CPF.' com contrato: '.$NumeroContrato.' registrado em consulta ou com status parcial/total';
		die(json_encode($response));
	}
	
	$averba = new Tbl_cartao_movimento();
	$averba->setDateTimeInsert(date("Y-m-d H:i:s"));
	$averba->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$averba->setCPF($CPF);
	$averba->setFK_Banco((int) $FK_Banco);
	$averba->setFK_Convenio((int) $FK_Convenio);
	$averba->setNumeroContrato($NumeroContrato);
	$averba->setNumeroMatricula($Matricula);
	$averba->setStatus('Consulta');
	$averba->setValorSolicitado(UTIL::formataValor($ValorContrato));
	$averba = $dao->save($averba);
	$response['Save'] = $averba->getPK_Movimento();
	$averba instanceof Tbl_cartao_movimento;
	//Registra Inclusão.
	$rec = new Tbl_cartao_log();
	$rec->setCPF($averba->getCPF());
	$rec->setFK_Convenio((int) $FK_Convenio);
	$rec->setFK_Movimento((int) $averba->getPK_Movimento());
	$rec->setNumeroMatricula($averba->getNumeroMatricula());
	$rec->setMensagem('Inclusao do movimento para cartao de credito.');
	$dao->save($rec);
	
	
	//Armazendo Log
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setFK_User((int) $FK_User);
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setOperacao( ('INSERT') );
	$log->setPagina(basename(__FILE__));
	$log->setPK_Registro((int) $averba->getPK_Movimento());
	$msg = '';
	$msg.= 'Depois: '.print_r((array) $averba,true);
	$log->setData($msg);
	$dao->save($log);
	//End Log
	
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}

die(json_encode($response));
?>