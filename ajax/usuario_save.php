<?php
//Rotina para Inserir/Alterar Cadastro de Banco;
require_once '../class/dao.class.php';
require_once '../class/tbl_user.class.php';
require_once '../class/tbl_user_banco.class.php';
require_once '../class/tbl_user_modulo.class.php';
require_once '../class/funcoes.php';

$PK_User = isset($_POST['PK_User']) ? $_POST['PK_User'] : false;
$CPF = isset($_POST['CPF']) ? $_POST['CPF'] : false;
$Nome = isset($_POST['Nome']) ? $_POST['Nome'] : false;
$Login = isset($_POST['Login']) ? $_POST['Login'] : false;
$Email = isset($_POST['Email']) ? $_POST['Email'] : false;
$Password = isset($_POST['Password']) ? $_POST['Password'] : false;

$Root = isset($_POST['Root']) ? true : false;
$Admin = isset($_POST['Admin']) ? true : false;

$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;

$perm['CARTAOCRED'] = isset($_POST['CARTAOCRED']) ? true : false;
$perm['CADASTRO'] = isset($_POST['CADASTRO']) ? true : false;
$perm['CONSULTA'] = isset($_POST['CONSULTA']) ? true : false;
$perm['PORTABILID'] = isset($_POST['PORTABILID']) ? true : false;
$perm['RECUPERACA'] = isset($_POST['RECUPERACA']) ? true : false;

$response['Erro'] = false;
$response['Save'] = false;

$dao = new DAO();


try{
	$tmp = null;	
	$usuario = new Tbl_user();
	if($PK_User){
		$usuario->setPK_User((int) $PK_User);
		$tmp = $dao->loadByField($usuario);
	}
	$usuario->setDateTimeInsert(date("Y-m-d H:i:s"));
	if($tmp) $usuario = $tmp;
	$usuario->setDateTimeUpdate(date("Y-m-d H:i:s"));
	$usuario->setCPF($CPF);
	$usuario->setNome($Nome);
	$usuario->setLogin($Login);
	$usuario->setPassword($Password);
	$usuario->setEmail($Email);
	$usuario->setRoot($Root);
	$usuario->setAdmin($Admin);
	$usuario = $dao->save($usuario);
	$response['Save'] = $usuario->getPK_User();
	
	//Gravando Permissões
	$_access = array('RECUPERACA','PORTABILID','CADASTRO','CONSULTA', 'CARTAOCRED');
	foreach($_access as $acess){
		$tAcesso = new Tbl_user_modulo();
		$tAcesso->setFK_User($usuario->getPK_User());
		$tAcesso->setModulo($acess);
		$tmp = $dao->loadByField($tAcesso);
		if($tmp) $tAcesso = $tmp;
		if($Root){
			$tAcesso->setLiberado(1);
		}else{
			$tAcesso->setLiberado( $perm[$acess] );
		}
		$dao->save($tAcesso);
	}
	
	if($FK_Banco){
		$user_banco = new Tbl_user_banco();
		$user_banco->setFK_User((int) $response['Save']);
		$user_banco->setFK_Banco((int) $FK_Banco);
		$dao->save($user_banco);
	}
}catch(Exception $e){
	$response['Erro'] = $e->getMessage();	
}
die(json_encode($response));
?>