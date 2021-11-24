<?php
    ob_start();
    include "db-function/db-genre.php";
    include "files/function.php";

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);


    if(!$id){
        $list = "<div class='insidePageNav'>Aller à une catégorie : <nav>";
        $titre = "Films par genres";
        $genres = getAllgenre();
        $tableFilms = "";
        foreach($genres as $genre){
            if($films = findFilmByGenre($genre["id"])){
                $list .= "<a href='#".$genre["nom"]."'>".$genre["nom"]."</a>";
                $tableFilms .= "<h2 id='".$genre["nom"]."'>".$genre["nom"]."</h2>";
                $tableFilms .= afficherTable($films, ["Titre", "Réalisateur", "Date de sortie"]);
            }
        }
        $list .= "</nav></div>";
    }elseif($genre = findGenreById($id)){
        $titre = $genre["nom_genre"];
        $list ="";
        $films = findFilmByGenre($id);
        $tableFilms = "<h1>Films dans la catégorie « $titre » :</h1>";
        $tableFilms .= afficherTable($films, ["Titre", "Réalisateur", "Date de sortie"]);
    }else{
        header("Location:index.php");
    }

?>

<?=$list?>
<?=$tableFilms?>

<?php
    $result = ob_get_clean();
    require "template.php";
?>