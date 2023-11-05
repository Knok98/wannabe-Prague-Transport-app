
<?php
require "SPOJnew.php";

$newDeparture = new SPOJ($_POST['routeF'], $_POST['routeT']);

$newDeparture->getData();

