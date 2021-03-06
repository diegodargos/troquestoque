<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_averb_movimento.class.php';
require_once '../class/tbl_averb_averbado.class.php';
require_once '../class/tbl_averb_log.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/util.class.php';
require_once '../class/funcoes.php';
//Verifica a conex�o ativa
checkSession();

$PK_Movimento = isset($_POST['PK_Movimento']) ? $_POST['PK_Movimento'] : false;
$CPF = isset($_POST['CPF']) ? $_POST['CPF'] : false;
$IOF = isset($_POST['IOF']) ? $_POST['IOF'] : false;
$Matricula = isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
$NumeroContrato = isset($_POST['NumeroContrato']) ? $_POST['NumeroContrato'] : false;
$Prazo = isset($_POST['Prazo']) ? $_POST['Prazo'] : false;
$TaxaJuros = isset($_POST['TaxaJuros']) ? $_POST['TaxaJuros'] : false;
$ValorContrato = isset($_POST['ValorContrato']) ? $_POST['ValorContrato'] : false;
$ValorExtra = isset($_POST['ValorExtra']) ? $_POST['ValorExtra'] : false;
$ValorParcela = isset($_POST['ValorParcela']) ? $_POST['ValorParcela'] : false;
$ValorRepasse = isset($_POST['ValorRepasse']) ? $_POST['ValorRepasse'] : false;

$Banco = isset($_POST['Banco']) ? $_POST['Banco'] : false;
$Agencia = isset($_POST['Agencia']) ? $_POST['Agencia'] : false;
$ContaCorrente = isset($_POST['ContaCorrente']) ? $_POST['ContaCorrente'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	
	$averbado = $dao->loadByQuery("SELECT * FROM tbl_averb_averbado WHERE FK_Movimento = '$PK_Movimento' AND Status = 'Ativo'", new Tbl_averb_averbado());
	if($averbado instanceof Tbl_averb_averbado){
		if($averbado->getValorParcela() > UTIL::formataValor($ValorParcela)){
			$response['Erro'] = "Valor Parcial da parcela superior ao novo valor solicitado";
		}
		if($averbado->getValorSolicitado() > UTIL::formataValor($ValorContrato)){
			$response['Erro'] = "Valor Parcial do movimento superior ao novo valor solicitado";
		}
	}
	if($response['Erro'] == false){	
		//Protecao contra duplicidade de movimento.
		$query = "SELECT * FROM tbl_averb_movimento WHERE PK_Movimento = '$PK_Movimento' ";
		$averba = $dao->loadByQuery($query, new Tbl_averb_movimento());
		if($averba instanceof Tbl_averb_movimento){
			$averba->setDateTimeUpdate(date("Y-m-d H:i:s"));
			$averba->setCPF($CPF);
			$averba->setFator(0);
			if($IOF) $averba->setIOF( UTIL::formataValor($IOF));
			$averba->setNumeroContrato($NumeroContrato);
			$averba->setNumeroMatricula($Matricula);
			$averba->setParcelas((int) $Prazo);
			if($TaxaJuros) $averba->setTaxaJuros(UTIL::formataValor($TaxaJuros));
			//$averba->setValorParcela(UTIL::formataValor($ValorParcela));
			$averba->setValorParcelaPendente(UTIL::formataValor($ValorParcela));
			//$averba->setValorSolicitado(UTIL::formataValor($ValorContrato));
			$averba->setValorSolicitadoPendente(UTIL::formataValor($ValorContrato));
			if($ValorExtra) $averba->setValorTotalExtra(UTIL::formataValor($ValorExtra));
			if($ValorRepasse) $averba->setValorRepasse(UTIL::formataValor($ValorRepasse));
			if($Banco) $averba->setCodigoBanco($Banco);
			if($Agencia) $averba->setCodigoAgencia($Agencia);
			if($ContaCorrente) $averba->setContaCorrente($ContaCorrente);
			
			$averba = $dao->save($averba);
			$response['Save'] = $averba->getPK_Movimento();
			$averba instanceof Tbl_averb_movimento;
			//Registra Altera��o.
			$rec = new Tbl_averb_log();
			$rec->setDateTimeInsert(date("Y-m-d H:i:s"));
			$rec->setCPF($averba->getCPF());
			$rec->setFK_Convenio((int) $averba->getFK_Convenio());
			$rec->setFK_Movimento((int) $averba->getPK_Movimento());
			$rec->setMatricula($averba->getNumeroMatricula());
			$rec->setMensagem('Alteracao do movimento de averbacao. Login: '.$_COOKIE['user'] );
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
		}else{
			$response['Erro'] = "Movimento Solicitado n�o pode ser alterado.";
		}
	}
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();
}

die(json_encode($response));
?>