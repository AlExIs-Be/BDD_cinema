<?php
    ob_start();
    include "files/db-function.php";
    include "files/function.php";

    $id = filter_input(INPUT_GET, "film", FILTER_VALIDATE_INT);
    $bio = "";
    $image = "";
    if(!$id){
        $titre = "Films par réalisateur";
        $reals = getAllReal();
        $affich = "<h1>Liste des films par réalisateurs</h1>";
        foreach($reals as $real){
            if($films = afficherFilmsDeReal($real["id"])){
                $affich .= "<h2 id='".$real["realisateur"]."'>".$real["realisateur"]."</h2>";
                $affich .= afficherTable($films, ["Titre", "Date de sortie"]);
            }
        }
    }else{
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
        $affich .= afficherTable(afficherFilmsDeReal($real["id"]), ["Titre", "Date de sortie"]);
    }
    
?>

<?=$affich?>

<?php
    $result = ob_get_clean();
    require "template.php";
?>