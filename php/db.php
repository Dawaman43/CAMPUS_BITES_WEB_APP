<?php

$host = 'localhost';
$port = '5432'; 
$dbname = 'campusbites';
$dbuser = 'postgres';
$dbpass = '1038';
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try{
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch (PDOException $e){
    echo "Connection failed:" . $e->getMessage();

}

