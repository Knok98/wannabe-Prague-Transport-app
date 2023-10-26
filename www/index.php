<?php

require __DIR__ . "/../vendor/autoload.php";

try {
    $dic = new \Idos\DIContainer();
    $app = new \Idos\App($dic);
    $app->boot();
} catch (Exception $e) {
    print $e->getMessage();
}