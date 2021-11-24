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

    /**
     * retourne tous les id et nom des genres en bdd
     */
    function getAllgenre(){
        $db = connexion();
        $sql = "SELECT id_genre AS id,
                    nom_genre AS nom
            FROM genre g";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * retrouve les films d'un genre par son identifiant
     * @param int $id identifiant du genre
     * @return array|false
     * dans l'ordre : id (film), titre, realisateur, annee
     */
    function findFilmByGenre($id){
        $db = connexion();
        $sql = "SELECT f.id_film AS id,
                titre_film AS titre,
                CONCAT(prenom_real, ' ', nom_real) as realisateur,
                DATE_FORMAT(date_sortie, '%d/%m/%Y') AS annee
            FROM film f, realisateur r, genre g, appartenir a
            WHERE f.id_real = r.id_real
            AND a.id_film = f.id_film
            AND a.id_genre = g.id_genre
            AND g.id_genre = :id
            ORDER BY date_sortie DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }