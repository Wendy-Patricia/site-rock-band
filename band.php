    <?php
        require_once 'band_generators.php';
    ?>
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
        main 
        {
            max-width: 800px;
            margin: 40px auto 80px auto;
            background: #fff;
            padding: 32px 32px 24px 32px;
            border-radius: 12px;
                box-shadow: 0 2px 12px rgba(30,28,28,0.08);
    }

    main p 
    {
        font-size: 18px;
        line-height: 1.7;
        color: #333;
        margin-bottom: 22px;
        text-align: justify;
        text-indent: 32px;
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
        <p>
            Måneskin (prononcé : [ˈmɔːnəˌske̝nˀ], « Clair de Lune » en danois) est un groupe de rock italien, formé à Rome en 2016.
        </p>
        <p>
            Il est composé de Damiano David (chant), Victoria De Angelis (basse), Thomas Raggi (guitare) et Ethan Torchio (batterie).

            Avec le titre rock Zitti e buoni, Måneskin gagne le Concours Eurovision de la chanson 2021, en tant que représentant de l'Italie. Cette victoire étend la notoriété du groupe sur la scène internationale et dans les charts, après déjà plusieurs succès dans son pays d'origine.

            Spotify a enregistré 22 millions d'auditeurs durant le mois de mai 2021
        </p>

        <p>
            Avec les sorties des deux albums studio, un extended-play et huit singles, ils atteignent le sommet des charts musicaux italiens et européens à diverses occasions, et récoltent 22 certifications platine et six certifications or de la Fédération de l'industrie musicale italienne (FIMI[3]), attestant de la vente de plus d’un million de disques en Italie, avant même leur victoire à l'Eurovision[4]. En 2021, Måneskin devient le premier groupe italien à atteindre le top 10 du UK Singles Chart. Leur single Zitti e buoni ainsi que la chanson I Wanna Be Your Slave atteignent le top 10 du Billboard Global 200 ex U.S.. Le 20 janvier 2023, ils sortent leur troisième album nommé Rush!.
        </p>
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

