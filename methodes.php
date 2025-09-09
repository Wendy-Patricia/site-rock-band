<?php
// La méthode HTTP correspondant à votre requête
$request_methode = $_SERVER['REQUEST_METHOD'];
echo "Méthode HTTP : " . htmlspecialchars($request_methode) . "<br>";

// L’URL complète de votre requête 
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http"; // certifica que o protocolo http esta activo
$host = $_SERVER['HTTP_HOST']; // nome do host do servidor
$requestUri = $_SERVER['REQUEST_URI']; // caminho da requete
$fullUrl = $protocol . "://" . $host . $requestUri; 

echo "URL complète : " . htmlspecialchars($fullUrl);
?>