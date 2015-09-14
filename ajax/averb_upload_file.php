<?php
require_once('../class/dao.class.php');

$tmp_file_name = $_FILES['Filedata']['tmp_name'];
$file = '../csv_averb/'.$_FILES['Filedata']['name'];
if(!is_dir('../csv_averb/')) mkdir('../csv_averb');
if( move_uploaded_file($tmp_file_name, $file) ){
	die($file);
}else{
	die('erro');
}
?>