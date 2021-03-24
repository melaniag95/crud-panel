<?php
try{
    $hostname = 'localhost';
    $dbname = 'corso';
    $user = 'root';
    $pass = '';

    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo 'Errore: '.$e->getMessage();
    die();
}


?>