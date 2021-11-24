<?php
    ob_start();
    include "files/db-function.php";
    include "files/function.php";

    $id = filter_input(INPUT_GET, "acteur", FILTER_VALIDATE_INT);

    if(!$id || !$acteur = findActorById($id)){
        header("Location:index.php");
    }
    $titre = $acteur["prenom"]." ".$acteur["nom"];
    if($image = $acteur["image"]);
    if($bio = $acteur["biographie"]);
    $tableRoles = afficherTable(findRolesOfActor($id), ["Titre", "Rôle", "Date de sortie"]);

?>
<div class="top">
    <div class="photo">
        <img src="<?=$image?>" alt="photo de <?=$titre?>">
    </div>
    <div>
        <h1><?= $titre ?></h1>
        <p>(né le <?= $acteur["dateNaissance"]?>)</p>
        <p><?=$bio?></p>
    </div>
</div>
            
<p><?= $titre ?> a joué dans :</p>
<p><?=$tableRoles?></p>

<?php
    $result = ob_get_clean();
    require "template.php";
?>