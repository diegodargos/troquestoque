<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_movimento.class.php';
require_once '../class/tbl_reserva.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/funcoes.php';

$PK_Movimento = isset($_POST['PK_Movimento']) ? $_POST['PK_Movimento'] : false;
$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
$FK_Convenio = isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
$FK_ImportacaoData = isset($_POST['FK_ImportacaoData']) ? $_POST['FK_ImportacaoData'] : false;
$CPF = isset($_POST['CPF']) ? $_POST['CPF'] : false;
$Identificador1	= isset($_POST['Identificador1']) ? $_POST['Identificador1'] : false;
$Identificador2	= isset($_POST['Identificador2']) ? $_POST['Identificador2'] : false;
$Matricula1	= isset($_POST['Matricula1']) ? $_POST['Matricula1'] : false;
$Matricula2	= isset($_POST['Matricula2']) ? $_POST['Matricula2'] : false;
$NumeroContrato	= isset($_POST['NumeroContrato']) ? $_POST['NumeroContrato'] : false;
$Parcela = isset($_POST['Parcela']) ? numberFormat($_POST['Parcela']) : false;
$Prazo = isset($_POST['Prazo']) ? (int) $_POST['Prazo'] : false;
$TaxaContrato = isset($_POST['TaxaContrato']) ? numberFormat($_POST['TaxaContrato']) : false;
$ValorFinanciado = isset($_POST['ValorFinanciado']) ? numberFormat($_POST['ValorFinanciado']) : false;
$ValorInadimplente = isset($_POST['ValorInadimplente']) ? numberFormat($_POST['ValorInadimplente']) : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

//Verificar se Movimento jс consta com status como reservado/averbado.
$query = "SELECT * FROM tbl_reserva WHERE FK_Movimento = '$PK_Movimento' AND Averbado <> '2'";
$reservas = $dao->listaFromQuery($query, new Tbl_reserva());
if($reservas || !empty($reservas)){
	file_put_contents('log_query.sql',$query);
	$response['Erro'] = utf8_encode('Movimento jс em processo de reserva/recuperaчуo.');
	die(json_encode($response));
}


$movimento = new Tbl_movimento();
$movimento->setPK_Movimento((int) $PK_Movimento);
$tmp = $dao->loadByField($movimento);
if($tmp){
	try{
		$movimento = $tmp;
		$movimento instanceof Tbl_movimento;
		$movimento->setStatus('Encerrado');
		$movimento->setDateTimeUpdate(date("Y-m-d H:i:s"));
		$movimento = $dao->save($movimento);
		
		$new = new Tbl_movimento();
		$new->setDateTimeInsert(date("Y-m-d H:i:s"));
		$new->setDateTimeUpdate(date("Y-m-d H:i:s"));
		$new->setFK_ImportacaoData((int) $movimento->getFK_Banco());
		$new->setFK_Banco((int) $movimento->getFK_Banco());
		$new->setFK_Convenio((int) $movimento->getFK_Convenio());
		$new->setFK_MovimentoPai((int) $movimento->getPK_Movimento());
		$new->setCPF($CPF);
		$new->setNumeroContrato($NumeroContrato);
		$new->setParcela($Parcela);
		$new->setTaxaContrato($TaxaContrato);
		$new->setStatus('Consulta');
		$new->setPrazo($Prazo);
		$new->setValorFinanciado($ValorFinanciado);
		$new->setValorInadimplente($ValorInadimplente);
		$new->setMatricula1($Matricula1);
		$new->setMatricula2($Matricula2);
		$new->setIdentificador1($movimento->getIdentificador1());
		$new->setIdentificador2($movimento->getIdentificador2());
		$new->setValorInadimplenteAtual($ValorInadimplente);
		$new = $dao->save($new);
	}catch(Exception $e){
		$response['Erro'] = utf8_encode($e->getMessage() .' - '. $e->getTraceAsString());
		die(json_encode($response));
	}
	$response['Save'] = true;
	
	//Logs
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setPagina(basename(__FILE__));
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setFK_User((int) $FK_User);
	$log->setPK_Registro((int) $new->getPK_Movimento());
	$log->setOperacao('UPDATE');
	$msg = '';
	if($movimento){
		$msg = 'Antes: '.print_r((array) $movimento,true).'\n';
	}
	$msg.= 'Depois: '.print_r((array) $new,true);
	$log->setData($msg);
	$dao->save($log);
	
}else{
	die(json_decode(array('Erro' => 'Chave do Movimento inexistente.', 'Save' => false)));
}
die(json_encode($response));
?>