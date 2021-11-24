<?php
    ob_start();
    include "files/db-function.php";
    include "files/function.php";

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    $list = "<div class='insidePageNav'>Aller à une catégorie : <nav>";

    if(!$id){
        $titre = "Films par genres";
        $genres = getAllgenre();
        $tableFilms = "";
        foreach($genres as $genre){
            if($films = findFilmByGenre($genre["id"])){
                $list .= "<a href='#".$genre["nom"]."'>".$genre["nom"]."</a>";
                $tableFilms .= "<h2 id='".$genre["nom"]."'>".$genre["nom"]."</h2>";
                $tableFilms .= afficherTable($films, ["Titre", "Date de sortie"]);
            }
        }
        $list .= "</nav></div>";
    }else{
        $titre = $nom;
        $tableFilms = "<h1>Films dans la catégorie « $nom » :</h1>";
        $tableFilms .= afficherTable($films, ["Titre", "Date de sortie"]);
        $nom = getNomGenre($id);
    }

?>

<?=$list?>
<?=$tableFilms?>

<?php
    $result = ob_get_clean();
    require "template.php";
?>