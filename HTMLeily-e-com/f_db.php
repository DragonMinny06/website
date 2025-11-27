<?php
$db_host = 'localhost';
$db_name = 'eily_gym';
$db_user = 'root'; // adapte à ton UwAmp, souvent root et soit root soit '' (vide)
$db_pass = ''; // ou '' selon config UwAmp

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
);
$pdo = new PDO($dsn, $db_user, $db_pass, $options);
?>