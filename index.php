<?php
session_start();
require_once 'band_generators.php';

if (!isset($_SESSION['nom_groupe'])) {
    $_SESSION['nom_groupe'] = "Baby Metal" ;
}

if (!isset($_SESSION['logo'])) {
    $_SESSION['logo'] = "logo/logo.png";
}


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
    <!--navbar com logo e nome da banda gerados dinamicamente -->
    <nav class="navbar">
        <div class="band-info">
            <img src="<?php echo generate_bandlogo() ?>" alt="Logo" class="band-logo">
            <div class="band-name">
                <?= htmlspecialchars(generate_bandname()) ?>
            </div>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="band.php">Band</a></li>
            <li><a href="#">Setlist</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- imagem da banda -->
    <main>
        <img src="maneskin.png" alt="Banda Maneskin" class="band-image">
    </main>

    <footer class="footer">
        <p>
            <?php
            // Array com os meses em francês
            $mois = [
                1 => 'janvier',
                2 => 'février',
                3 => 'mars',
                4 => 'avril',
                5 => 'mai',
                6 => 'juin',
                7 => 'juillet',
                8 => 'août',
                9 => 'septembre',
                10 => 'octobre',
                11 => 'novembre',
                12 => 'décembre'
            ];
            $jour = date('d');
            $mois_num = date('n');
            $annee = date('Y');
            $heure = date('H:i');
            echo "Nous sommes le $jour {$mois[$mois_num]} $annee, il est $heure";
            ?>
        </p>
    </footer>
</body>

</html>