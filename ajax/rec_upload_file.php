<?php
require_once('../class/dao.class.php');

$tmp_file_name = $_FILES['Filedata']['tmp_name'];
$file = '../csv_rec/'.$_FILES['Filedata']['name'];
if(!is_dir('../csv_rec/')) mkdir('../csv_rec');
if( move_uploaded_file($tmp_file_name, $file) ){
	die($file);
}else{
	die('erro');
}


?>