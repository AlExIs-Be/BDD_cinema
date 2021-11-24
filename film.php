<?php
    ob_start();
    include "db-function/db-film.php";
    include "files/function.php";

    $id = filter_input(INPUT_GET, "film", FILTER_VALIDATE_INT);

    if(!$id || !$film = findFilmById($id)){
        header("Location:index.php");
    }
    $tableActeurs =afficherTable(findAllActorsinFilm($id), ["Role", "Acteur"]);
    $tab = explode(" - ", $film["genre"]);
    $genres = "";
    foreach($tab as $id_genre){  
        $genre = findGenreById($id_genre);
        $genres .= "<a href='genre.php?id=$id_genre'>".$genre["nom_genre"]."</a>&nbsp;&nbsp;";
    }

?>

<div class="top">
    <div class="photo">
        <img src='<?= $film["affiche"]?>' alt='affiche du film <?= $film["titre"]?>'>
    </div>
    <div>
        <h1><?= $film["titre"]?></h1>
        <p class="little">( <?= $film["duree"]?> )
        sorti le <?= $film["annee"]?>
        réalisé par <a href='realisateur.php?film=<?=$film["id"]?>'><?= $film["realisateur"]?></a>
        </p>
        <p>Genre : <?=$genres?></p>
        <p>Note IMDb : <?= $film["note"]?>/10</p>
    </div>
</div>

<h3>Résumé du film : </h3>
<p><?= $film["resume"]?></p>
<p><?=$tableActeurs?></p>

<?php

    $titre = $film["titre"];
    $result = ob_get_clean();
    require "template.php";
?>