<?php

$db_host = "localhost";
$db_name = "mytest";
$db_user = "root";
$db_pass = "";

//No space

$dsn = "mysql:host={$db_host};dbname={$db_name}";

//PDO PHP data object

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //associative array
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'" //first SQL command
];

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

if(!isset($_SESSION)) {
    session_start();
}