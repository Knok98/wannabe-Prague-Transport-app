
<?php
require "SPOJ.php";
if(!$_POST['routeF']||!$_POST['routeT']){
    echo "hodnota nebyla zaslána";
    return 0;
}
$from=ucfirst(str_replace(" ","%",trim($_POST['routeF'])));
$to=ucfirst(str_replace(" ","%",trim($_POST['routeT'])));
$url="https://idos.idnes.cz/vlakyautobusymhdvse/spojeni/vysledky/?f=".$from."&fc=301003&t=".$to."&tc=301003";



$newDeparture=new SPOJ($url);
$newDeparture->createWindow();
$newDeparture->getData();

