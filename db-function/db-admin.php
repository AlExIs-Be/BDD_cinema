<?php

    /**
     * Retourne une instance de PDO, représentant la connexion à la base de données
     * @return \PDO un objet instance de PDO, connecté à la base de données
     */
    function connexion()
    {
        return new \PDO(
            "mysql:dbname=cinema;host=localhost:3306",
            "root",
            "",
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            ]
        );
    }
    /**
     * retourne tous les films de la bdd
     * dans l'ordre : id, titre, date, duree, resume, affiche, note, id_real
     */
    function getAllFilms(){
        $db = connexion();
        $sql = "SELECT id_film AS id,
                titre_film AS titre,
                DATE_FORMAT(date_sortie, '%d/%m/%Y') AS annee,
                TIME_FORMAT(SEC_TO_TIME(duree_film*60), '%lh%i') AS duree,
                resume_film AS resume,
                affiche_film AS affiche,
                note_film AS note,
                CONCAT(prenom_real, ' ', nom_real) AS realisateur
            FROM film f, realisateur r
            WHERE f.id_real = r.id_real";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * retourne tous les réalisateurs en bdd
     * id, nom_prenom as realis
     */
    function getAllReals(){
        $db = connexion();
        $sql = "SELECT id_real AS id,
                    CONCAT(prenom_real, ' ', nom_real) AS realis
            FROM realisateur
            ORDER BY nom_real";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * Fonction pour renseigner un nouveau film dans la bdd
     * @param array - ensemble des valeurs à insérer dans la base
     */
    function addFilm($array){
        $db = connexion();
        $sql = "INSERT INTO film (titre_film, date_sortie, duree_film, resume_film, affiche_film, note_film, id_real)
                VALUES (:titre, :date, :duree, :resume, :affiche, :note, :real)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":titre", $array['titre']);
        $stmt->bindParam(":date", $array['date']);
        $stmt->bindParam(":duree", $array['duree']);
        $stmt->bindParam(":resume", $array['resume']);
        $stmt->bindParam(":affiche", $array['affiche']);
        $stmt->bindParam(":note", $array['note']);
        $stmt->bindParam(":real", $array['real']);
        $stmt->execute();
    }
    /**
     * @return $table            -  retourne un tableau HTML avec entêtes
     * @param array $array       - tableau des valeurs à afficher
     * @param array $array_titre - tableau des entêtes associés aux valeurs à afficher 
     */
    function afficherTable($array, $array_titre){
        $table = "<table><thead><tr>";
        foreach($array_titre as $entete){
            $table .= "<th>$entete</th>";
        }
        $table .= "<th>Edit</th></tr></thead><tbody>";
        foreach($array as $item){
            $table .= "<tr>";
            foreach($item as $value){
                $value = mb_strimwidth("$value", 0, 30, "...");
                $table .= "<td>$value</td>";
            }
            $table .= "<td><a href=''>Editer</a> <a href=''>Supprimer</a></td></tr>";
        }
        $table .= "</tbody></table>";
        return $table;
    }