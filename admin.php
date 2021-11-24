<?php
    ob_start();
    include "db-function/db-admin.php";
    $titre = "Ajouter/Modifier Film";
    $films = getAllFilms();
    $reals = getAllReals();
    $opt = "";
    foreach($reals as $real){
        $opt .= "<option value=".$real["id"].">".$real["realis"]."</option>";
    }
    $affichTable = afficherTable($films, ["Id", "Titre", "Date de sortie", "Durée", "Résumé", "Affiche", "Note", "Réalisateur"]);

?>
<section>
    <form action="traitement.php?action=newFilm" method="post">
        <h3>Ajouter un nouveau film</h3>
        <div class="edit">
        <p>
            <label>
                Titre du film :
                <input type="text" name="titre" value="">
            </label>
        </p>
        <p>
            <label>
                Date de sortie :
                <input type="date" name="date" value="">
            </label>
        </p>
        <p>
            <label>
                Durée (min):
                <input class="inputNumber" type="number" step="any" name="duree" value="">
            </label>
        </p>
        <p>
            <label>
                Résumé :
                <textarea name="resume" rows=3></textarea>
            </label>
        </p>
        <p>
            <label>
                Lien de l'affiche :
                <input type="text" name="affiche" value="">
            </label>
        </p>
        <p>
            <label>
                Note du film (/10):
                <input class="inputNumber" type="number" step="any" name="note" value="">
            </label>
        </p>
        <p>
            <label>
                Réalisateur :
                <select name="realisateur">
                    <?=$opt?>
                </select>
            </label>
        </p>
        </div>
        <p>
            <input type="submit" name="submit" value="Valider">
        </p>
    </form>
</section>
<div class="adminTable">
    <?=$affichTable?>
</div>

<?php
$result = ob_get_clean();
include "template.php";


/* SELECT TABLE_NAME
    FROM INFORMATION_SCHEMA.TABLES
    WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA+'dbName'
    <form action="admin.php?action=choisir" method="post">
    <label for="action">Quelle action effectuer sur la base de donnée ?</label>
    <select id="action" name="action">
        <option value="insert">Rajouter une entrée</option>
        <option value="update">Modifier une entrée</option>
        <option value="delete">Supprimer une entrée</option>
    </select>
    <label for="">dans quelle table ?</label>
    <select id="table" name="table">
        <option value=""></option>
    </select>
    </form>*/
