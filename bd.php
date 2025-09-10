<?php
//ligação PDO à base de dados

$host = "localhost";
$dbname = "myband";
$username = "wendy";    // o user que criaste no TO DO 3
$password = "1234"; // a senha que escolheste

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // para gerar exccesoes ja que por default pdo envia so falso quando ha erros
} catch (PDOException $e) {
    die("Erro de ligação à base de dados: " . $e->getMessage());
}
