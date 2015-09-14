<?php 
require_once 'class/dao.class.php';
require_once 'class/tbl_user.class.php';
require_once 'class/tbl_log.class.php';
require_once 'class/template.class.php';

$user = isset($_POST['user']) ? addslashes($_POST['user']) : false;
$password = isset($_POST['passwd']) ? md5($_POST['passwd']) : false;

if($user == 'diego'){
	$sessionTime = time() + 1800;
	$sessionName = uniqid('session_');
	setcookie("user", $user, $sessionTime ); //1 hora
	setcookie("userData",$user, $sessionTime ); //1 hora
	setcookie("session", $sessionName, $sessionTime); //1 hora
	file_put_contents("sessions/".$sessionName, "$sessionTime\n$user");
	
	header("location: load.php?Arg=Anunciar");
}else{
	header("location: index.php");
}
?>