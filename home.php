<?php
require_once 'class/template.class.php';
require_once 'class/dao.class.php';
require_once 'class/tbl_log.class.php';
require_once 'class/funcoes.php';

//Verifica a conexão ativa
checkSession();

$template = new Template();
$dao = new DAO();

$layout = basename(__FILE__,'.php');
$template->loadFromFile("template/{$layout}.html");

//Armazendo Log
$FK_User = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;

die($template->show());
?>