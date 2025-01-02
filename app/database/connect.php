<?php
$driver = "mysql";
$host = "127.0.0.1:3307";
$user = "root";
$password = "";
$dbname = "contact_form";
$charset = "utf8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $pdo = new PDO("$driver:host=$host;dbname=$dbname;charset=$charset", $user, $password, $options);
}catch (PDOException $e){
    die("Connection failed: " . $e->getMessage());
}