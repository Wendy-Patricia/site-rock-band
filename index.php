<?php
// Forçar recarregamento da sessão
//session_unset();
//session_destroy();
//session_start();
require_once 'header.php';

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bands</title>
</head>

<body>
    <!-- imagem da banda -->
    <main>
        <img src="photos/babymetal.jpg" alt="Banda Maneskin" class="band-image">
    </main>
</body>

</html>

<?php require_once 'footer.php'; ?>