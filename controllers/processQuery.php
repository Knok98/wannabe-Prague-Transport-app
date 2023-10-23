
<?php
require "SPOJ.php";
session_start();
@$_SESSION["ticket"];
$from=ucfirst(str_replace(" ","%20",trim($_POST['routeF'])));
$to=ucfirst(str_replace(" ","%20",trim($_POST['routeT'])));
$info="".$_POST['routeF'].",".$_POST['routeT']."";
$url="https://idos.idnes.cz/vlakyautobusymhdvse/spojeni/vysledky/?f=".$from."&fc=301003&t=".$to."&tc=301003";

$ID=0;
if($_POST['idDiv']){
   $ID=$_POST['idDiv'];
}
$newDeparture=new SPOJ($url,$info,$ID);

$newDeparture->getData();


