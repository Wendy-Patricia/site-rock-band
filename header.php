<?php
    session_start(); 
    require 'bd.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Bands</title>
</head>
    <nav>
        <!--navbar com logo e nome da banda gerados dinamicamente -->
        <nav class="navbar">
            <div class="band-info">
                <img src="<?php echo $_SESSION['logo'] ?>" alt="Logo" class="band-logo">
                <div class="band-name">
                    <?= htmlspecialchars($_SESSION['nom_groupe']) ?>
                </div>

            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="band.php">Band</a></li>
                <li><a href="setlist.php">Setlist</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </nav>