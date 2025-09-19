<?php
session_start();
require 'bd.php';

if (isset($_GET['disconnect']) && $_GET['disconnect'] == 1) {
    session_destroy(); // Détruit la session
    header("Location: " . $_SERVER['PHP_SELF']); // Recharge la page proprement
    exit;
}

// --- Connexion ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // vérifier dans une base de données
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérification 
    if ($username === 'admin' && $password === '1234') {
        $_SESSION['connected'] = true;
        $_SESSION['username'] = $username;
    } else {
        $error = "Identifiants incorrects";
    }
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
    <nav class="navbar">
        <div class="band-info"><img src="logos/logo.jpg" alt="Logo" class="band-logo">
            <div class="band-name">babymetal</div>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li>
                <?php if (isset($_SESSION['connected']) && $_SESSION['connected']): ?>
                    <a href="?disconnect=1" class="connect-btn">Déconnexion</a>
                <?php else: ?>
                    <a id="connectBtn" class="connect-btn">Connexion</a>
                <?php endif; ?>

            </li>
            <li><a href="band.php">Band</a></li>
            <li><a href="setlist.php">Setlist</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- Modal de connexion -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="form-title">Admin login</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Your username" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Your password" required>
                </div>
                <div class="button-group">
                    <button type="reset" name="cancel" class="cancel-btn">Cancel</button>
                    <button type="submit" name="login" class="submit-btn">Login</button>
                </div>
                <?php if (!empty($login_error)): ?>
                    <div class="error-message"><?php echo $login_error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        // Gestion de la modal de connexion
        document.addEventListener('DOMContentLoaded', function() {
            let modal = document.getElementById('loginModal');
            let btn = document.getElementById('connectBtn');
            let span = document.getElementsByClassName('close')[0];// recupera o elemento <span> que fecha a modal

            //quando o usuario clicar no botao, abre a modal
            if (btn) {
                btn.onclick = function() {
                    modal.style.display = 'block';
                }
            }

            //quando o usuario clicar no <span> (x), fecha a modal
            if (span) {
                span.onclick = function() {
                    modal.style.display = 'none';
                }
            }

            //quando o usuario clicar fora da modal, fecha a modal
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            // Afficher la modal s'il y a une erreur de connexion
            <?php if (!empty($login_error)): ?>
                if (modal) modal.style.display = 'block';
            <?php endif; ?>
        });
    </script>