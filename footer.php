<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bands</title>
</head>
<body>
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