<?php
    session_start();
    $PHOTOS_DIR = "./photos";
    $logo_img = $_GET["logo"];

    echo file_get_contents($PHOTOS_DIR."/".$logo_img); //Renvoi le contenu binaire d’une fichier

?>