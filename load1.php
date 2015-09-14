<?php
require_once 'class/template.class.php';

$template = new Template();
$pag = $_POST['Pagina'];
$html  = $template->getContextFromFile('template/'.$pag.'.html');
die($html);
?>

