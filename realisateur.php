<?php
    ob_start();
    include "db-function/db-realisateur.php";
    include "files/function.php";

    $id = filter_input(INPUT_GET, "film", FILTER_VALIDATE_INT);
    $bio = "";
    $image = "";
    if(!$id){
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if(!$id){
            $titre = "Films par réalisateur";
            $reals = getAllReal();
            $affich = "<h1>Liste des films par réalisateurs</h1>";
            foreach($reals as $real){
                if($films = afficherFilmsDeReal($real["id"])){
                    $affich .= "<h2><a href='realisateur.php?id=".$real["id"]."'>".$real["realisateur"]."</a></h2>";
                    $affich .= afficherTable($films, ["Titre", "Genre", "Date de sortie"]);
                }
            }
        }else{
            $real = findRealbyID($id);
            $titre = $real["realisateur"];
            $affich = "<div class='top'>
                            <div class='photo'>
                                <img src='$image' alt='photo de $titre'>
                            </div>
                            <div>
                                <h1>$titre</h1>
                                <p>$bio</p>
                            </div>
                        </div>       
                        <p>$titre a réalisé :</p>";
            $affich .= afficherTable(afficherFilmsDeReal($real["id"]), ["Titre", "Genre", "Date de sortie"]);
        }
    }else{
        $real = findRealByIdFilm($id);
        $titre = $real["realisateur"];
        $affich = "<div class='top'>
                        <div class='photo'>
                            <img src=$image alt='photo de $titre'>
                        </div>
                        <div>
                            <h1>$titre</h1>
                            <p>$bio</p>
                        </div>
                    </div>       
                    <p>$titre a réalisé :</p>";
        $affich .= afficherTable(afficherFilmsDeReal($real["id"]), ["Titre", "Genre", "Date de sortie"]);
    }
    
?>

<?=$affich?>

<?php
    $result = ob_get_clean();
    require "template.php";
?>