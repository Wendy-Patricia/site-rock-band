<?php
$host = "localhost";     // ou 127.0.0.1
$db   = "myband";       // nome do banco
$user = "root";          // usuário do MySQL
$pass = "";              // senha (no XAMPP normalmente é vazio)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la BD : " . $e->getMessage());
}
?>
