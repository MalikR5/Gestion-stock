<?php
$host = 'localhost';
$db   = 'gestion_stock_simple';
$user = 'root';
$pass = 'root'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
