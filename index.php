<?php
$titre = "Welcome to my first php page :)";
$nom = "Hi my name is wendy patricia";
?>
<body>
    <header>
        <h1><?= htmlspecialchars($titre) ?></h1>
        <div class="lead"><?= htmlspecialchars($nom) ?></div>
    </header>
</body>
<style>
    body{
        height:100%; 
        margin:0; 
        background: #0a95957b; 
        color:#111827;}
</style>