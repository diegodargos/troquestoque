<?php
require_once 'class/template.class.php';
require_once 'class/dao.class.php';
require_once 'class/tbl_log.class.php';
require_once 'class/funcoes.php';

//Verifica a conexão ativa
//if(!checkSession()) die(header("location: 404.php"));

$Page = isset($_GET['Arg']) ? $_GET['Arg'] : false;
if(!$Page){
	header("location: 404.php");
}

//$dao = new DAO();

//Armazendo Log
$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
if($Page == 'Anunciar' && !$FK_User){
	header("location: 404.php");
}

/*
$log = new Tbl_log();
$log->setDateTimeInsert(date("Y-m-d H:i:s"));
$log->setFK_User((int) $FK_User);
$log->setIP($_SERVER['REMOTE_ADDR']);
$log->setOperacao('SELECT');
$log->setPagina(basename(__FILE__));
$log->setPK_Registro(0);
$log->setData("Acesso a pagina $Page");
$dao->save($log);
*/
$template = new Template();
//$dao = new DAO();
$template->loadFromFile("template/{$Page}.html");

if(!$FK_User){
	$mainmenu  = $template->getContextFromFile('template/menu.html');
	$menuleft  = $template->getContextFromFile('template/menuleft.html');
}else{
	$mainmenu  = $template->getContextFromFile('template/menu.html');
	$menuleft  = $template->getContextFromFile('template/menuleft.html');
}

$template->changeTag2Array(array("{MainMenu}" => $mainmenu , "{MenuLeft}" => $menuleft));

//By Felipe - 17/03 - Submenus

if(substr($Page,0,3) == "cad"){
	$submenu = $template->getContextFromFile('template/sbm_cadastro.html');
	$template->changeTag2Array(array("{sbm_cadastro}" => $submenu));
}elseif(substr($Page,0,3) == "rec"){
	$submenu = $template->getContextFromFile('template/sbm_recuperacao.html');
	$template->changeTag2Array(array("{sbm_recuperacao}" => $submenu));
}elseif(substr($Page,0,5) == "averb"){
	$submenu = $template->getContextFromFile('template/sbm_averbacao.html');
	$template->changeTag2Array(array("{sbm_averbacao}" => $submenu));
}elseif(substr($Page,0,6) == "cartao"){
	$submenu = $template->getContextFromFile('template/sbm_cartao.html');
	$template->changeTag2Array(array("{sbm_cartao}" => $submenu));
}elseif(substr($Page,0,4) == "cons"){
	$submenu = $template->getContextFromFile('template/sbm_cons.html');
	$template->changeTag2Array(array("{sbm_cons}" => $submenu));
}

/*$modulos = $dao->listaFromQuery("SELECT * FROM tbl_user_modulo WHERE FK_User = '$FK_User'", new stdClass());
foreach($modulos as $modulo){
	if($modulo->Liberado != 1){
		$template->setContextByDefiner("", "<!--{$modulo->Modulo}.Start-->", "<!--{$modulo->Modulo}.End-->");
	}
}*/

die($template->show());
?>