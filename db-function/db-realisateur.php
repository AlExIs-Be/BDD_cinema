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
     * retourne tous les réalisateurs en bdd
     * 
     */
    function getAllReal(){
        $db = connexion();
        $sql = "SELECT id_real AS id,
                    CONCAT(prenom_real, ' ', nom_real) AS realisateur
            FROM realisateur
            ORDER BY nom_real";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * Retourne l'id et les nom/prenoms du realisateur en base de données correspondant à l'id du film en paramètre
     * 
     * @param int        - $id l'identifiant du film en BDD
     * @return array|false - (int)identifiant et (string) prenom nom  du réalisateur
     */
    function findRealById($id)
    {
        $db = connexion();
        $sql = "SELECT id_real AS id, 
                CONCAT(prenom_real, ' ', nom_real) AS realisateur
            FROM realisateur r
            WHERE id_real = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    /**
     * Retourne l'id et les nom/prenoms du realisateur en base de données correspondant à l'id du film en paramètre
     * 
     * @param int        - $id l'identifiant du film en BDD
     * @return array|false - (int)identifiant et (string) prenom nom  du réalisateur
     */
    function findRealByIdFilm($id)
    {
        $db = connexion();
        $sql = "SELECT f.id_real AS id, 
                CONCAT(prenom_real, ' ', nom_real) AS realisateur
            FROM film f, realisateur r
            WHERE f.id_film = :id
            AND f.id_real = r.id_real";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    /**
     * retourne un tableau des films du réalisateur identifié par $id
     * @param int $id - identifiant du réal en bdd
     * @return array|false tableau des films 
     * dans l'ordre : id, titre, genre, annee
     */
    function afficherFilmsDeReal($id){
        $db = connexion();
        $sql = "SELECT f.id_film AS id,
                titre_film AS titre,
                GROUP_CONCAT(g.id_genre SEPARATOR ' - ') as genre,
                DATE_FORMAT(date_sortie, '%d/%m/%Y') AS annee
            FROM film f, realisateur r, appartenir a, genre g
            WHERE f.id_real = r.id_real
            AND r.id_real = :id
            AND a.id_genre = g.id_genre
            AND a.id_film = f.id_film
            GROUP BY f.id_film
            ORDER BY date_sortie DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * retourne un genre par son id
     * @return array|false [id_genre, nom_genre]
     */
    function findGenreById($id)
    {
        $db = connexion();
        $sql = "SELECT * FROM genre WHERE id_genre = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }