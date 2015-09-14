<?php
require_once 'class/template.class.php';

$template = new Template();

$mainmenu  = $template->getContextFromFile('template/menu.html');
$menuleft = $template->getContextFromFile('template/menuleft.html');
$home = $template->getContextFromFile('template/home.html');
$template->loadFromFile('template/home.html');
$template->changeTag2Array(array("{MainMenu}" => $mainmenu , "{MenuLeft}" => $menuleft , "{Pagina}" => $home));
die($template->show());
?>

