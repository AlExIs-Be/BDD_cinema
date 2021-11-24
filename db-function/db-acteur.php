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
     * retourne un tableau avec les données de l'acteur
     * @param int $id - identifiant de l'acteur dans la bdd
     * @return array|false 
     * dans l'ordre : prenom, nom, sexe, dateNaissance
     */
    function findActorById($id){
        $db = connexion();
        $sql = "SELECT prenom_acteur AS prenom,
                nom_acteur AS nom, 
                sexe_acteur AS sexe,
                DATE_FORMAT(naissance_acteur, '%d/%m/%Y') AS dateNaissance,
                image_acteur AS image,
                biographie_acteur AS biographie
            FROM acteur a
            WHERE id_acteur = :id";    
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }