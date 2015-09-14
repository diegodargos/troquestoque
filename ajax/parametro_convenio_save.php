<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_convenio_parametro.class.php';
require_once '../class/funcoes.php';

////Verifica a conexão ativa
checkSession();

$FK_Convenio = isset($_POST['FK_Convenio']) ? (int) $_POST['FK_Convenio'] : false;
$Attribute = isset($_POST['Attribute']) ? $_POST['Attribute'] : false;
$PK_Convenio_Parametro = isset($_POST['PK_Convenio_Parametro']) ? (int) $_POST['PK_Convenio_Parametro'] : false;
$Type = isset($_POST['Type']) ? $_POST['Type'] : false;
$Varname = isset($_POST['Varname']) ? $_POST['Varname'] : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();

try{
	$tmp = null;	
	$parametro = new Tbl_convenio_parametro();
	if($PK_Convenio_Parametro){
		$parametro->setPK_Convenio_Parametro($PK_Convenio_Parametro);
		$tmp = $dao->loadByField($parametro);
	}
	$parametro->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $parametro = $tmp;
	$parametro->setFK_Convenio($FK_Convenio);
	$parametro->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$parametro->setAttribute($Attribute);
	$parametro->setType($Type);
	$parametro->setVarname($Varname);
	//Constantes
	$parametro->setCssSelector(null);
	$parametro->setFK_Etapa(1);
	$parametro->setMethod('POST');
	//Salvando
	$parametro = $dao->save($parametro);
	$response['Save'] = $parametro->getPK_Convenio_Parametro();
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>