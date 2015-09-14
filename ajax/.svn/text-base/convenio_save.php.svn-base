<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_log.class.php';
require_once '../class/tbl_convenio.class.php';
require_once '../class/funcoes.php';

//Verifica a conexão ativa
checkSession();

$PK_Banco = isset($_POST['PK_Banco']) ? $_POST['PK_Banco'] : false;
$Nome = isset($_POST['Nome']) ? $_POST['Nome'] : false;

$PK_Convenio = isset($_POST['PK_Convenio']) ? $_POST['PK_Convenio'] : false;
$FK_Sistema = isset($_POST['FK_Sistema']) ? $_POST['FK_Sistema'] : false;
$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
$FK_Orgao = isset($_POST['FK_Orgao']) ? $_POST['FK_Orgao'] : false;
$Nome = isset($_POST['Nome']) ? $_POST['Nome'] : false;
$ValorMinimo = isset($_POST['ValorMinimo']) ? numberFormat($_POST['ValorMinimo']) : false;
$ValorMaximo = isset($_POST['ValorMaximo']) ? numberFormat($_POST['ValorMaximo']) : false;
$PrazoMaximo = isset($_POST['PrazoMaximo']) ? $_POST['PrazoMaximo'] : false;
$Processo = isset($_POST['Processo']) ? $_POST['Processo'] : false;
$Descricao = isset($_POST['Descricao']) ? $_POST['Descricao'] : false;

$TipoProcesso = isset($_POST['TipoProcesso']) ? $_POST['TipoProcesso'] : false;
$ConexaoUnica = isset($_POST['ConexaoUnica']) ? 1 : 0;

$QtMinutoMinimo = isset($_POST['QtMinutoMinimo']) ? $_POST['QtMinutoMinimo'] : false;
$QtMinutoMaximo = isset($_POST['QtMinutoMaximo']) ? $_POST['QtMinutoMaximo'] : false;
$QtRegistroMinima = isset($_POST['QtRegistroMinima']) ? $_POST['QtRegistroMinima'] : false;
$QtRegistroMaxima = isset($_POST['QtRegistroMaxima']) ? $_POST['QtRegistroMaxima'] : false;

$DiasRecorrencia = isset($_POST['DiasRecorrencia']) ? $_POST['DiasRecorrencia'] : 0;

$ProxyAddress = isset($_POST['ProxyAddress']) ? $_POST['ProxyAddress'] : "";
$ProxyPort = isset($_POST['ProxyPort']) ? $_POST['ProxyPort'] : "";
$ProxyUser = isset($_POST['ProxyUser']) ? $_POST['ProxyUser'] : "";
$ProxyPassword = isset($_POST['ProxyPassword']) ? $_POST['ProxyPassword'] : "";

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	$tmp = null;	
	$convenio = new Tbl_convenio();
	if($PK_Convenio){
		$convenio->setPK_Convenio($PK_Convenio);
		$tmp = $dao->loadByField($convenio);
	}
	$convenio->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $banco = $tmp;
	$convenio->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$convenio->setFK_Banco((int)$FK_Banco);
	$convenio->setFK_Orgao((int) $FK_Orgao);
	$convenio->setFK_Sistema((int) $FK_Sistema);
	$convenio->setDescricao($Descricao);
	$convenio->setValorMaximo($ValorMaximo);
	$convenio->setValorMinimo($ValorMinimo);
	$convenio->setProcesso($Processo);
	$convenio->setPrazoMaximo((int) $PrazoMaximo);
	$convenio->setNome($Nome);
	$convenio->setQtMinutoMaximo((int) $QtMinutoMaximo);
	$convenio->setQtMinutoMinimo((int) $QtMinutoMinimo);
	$convenio->setQtRegistroMinima((int) $QtRegistroMinima);
	$convenio->setQtRegistroMaxima((int) $QtRegistroMaxima);
	$convenio->setConexaoUnica($ConexaoUnica);
	$convenio->setDiasRecorrencia((int) $DiasRecorrencia);
	$convenio->setTipoProcesso($TipoProcesso);
	//Proxy
	$convenio->setProxyAddress($ProxyAddress);
	$convenio->setProxyPort($ProxyPort);
	$convenio->setProxyUser($ProxyUser);
	$convenio->setProxyPassword($ProxyPassword);
	$convenio = $dao->save($convenio);
	$response['Save'] = $convenio->getPK_Convenio();
	
	//Armazendo Log
	$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	$log = new Tbl_log();
	$log->setDateTimeInsert(date("Y-m-d H:i:s"));
	$log->setFK_User((int) $FK_User);
	$log->setIP($_SERVER['REMOTE_ADDR']);
	$log->setOperacao( ($PK_Banco ? 'UPDATE' : 'INSERT') );
	$log->setPagina(basename(__FILE__));
	$log->setPK_Registro((int) $convenio->getPK_Convenio());
	$msg = '';
	if($PK_Convenio){
		$msg = 'Antes: '.print_r((array) $tmp,true).'\n';
	}
	$msg.= 'Depois: '.print_r((array) $convenio,true);
	$log->setData($msg);
	$dao->save($log);
	//End Log
	
	
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>