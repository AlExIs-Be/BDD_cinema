<?php
    ob_start();
    include "db-function/db-film.php";
    include "files/function.php";
    
    $tableFilms = afficherTable(findAllFilms(), ["Titre", "Date de sortie", "Durée", "Réalisateur", "Genre"]);
?>

<h1>Liste des films dans la base</h1>
<?= $tableFilms?>

<?php

    $titre = "Liste des Films";
    $result = ob_get_clean();
    require "template.php";
?>

