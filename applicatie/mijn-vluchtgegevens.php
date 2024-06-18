<?php 

session_start();

if(
    !isset($_SESSION['username']) ||
    !isset($_SESSION['passagiernummer'])
) {
    header('Location: /');
    exit();
}

require_once 'db_connectie.php';
$db = maakVerbinding();