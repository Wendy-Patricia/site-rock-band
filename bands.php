<?php
require_once 'band_generators.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bands</title>
    <style>
        /* Estilos básicos para melhorar a aparência */
           body
        { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background-color: #f0f0f0; 
        }
        .navbar 
        { 
            background-color: #1e1c1cff; 
            color: white; 
            padding: 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .navbar ul 
        { 
            list-style: none; 
            display: flex; 
            margin: 0; 
            padding: 0; 
        }
        .navbar li 
        { 
            margin: 0 15px; 
        }
        .navbar a 
        { 
            color: white; 
            text-decoration: none; 
        }
        .band-info {
            display: flex;
            align-items: center;
        }
        .band-logo {
            max-width: 85px;
            height: auto;
            margin-right: 20px;
        }
        .band-name 
        { 
            font-size: 24px; 
            font-weight: bold; 
            color: #817e7eff;
            font-family: 'Courier New', Courier, monospace;
        }
        .band-image
        {
            display: block;  
            max-width: 2000px; 
            width: 100%;
            height: auto;
        }
        .footer
        {
            background-color: #1e1c1cff;
            color: #8f8282ff;
            text-align: center;
            font-size: 15px;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
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
            <li><a href="bands.php">Home</a></li>
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
                    1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
                    5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
                    9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
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