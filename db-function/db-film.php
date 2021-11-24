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
     * Retourne tous les films de la base de données
     * 
     * @return array|false 
     * Renvoie un tableau contenant les films sous forme de tableau,
     * dans l'ordre : id, titre, annee, duree, realisateur, genre
     * un tableau vide si aucun film n'est présent en base
     * ou FALSE si la requète a échoué
     */
    function findAllFilms()
    {
        $db = connexion();
        $sql = "SELECT f.id_film AS id, 
                    titre_film AS titre, 
                    DATE_FORMAT(date_sortie, '%d/%m/%Y') AS annee, 
                    TIME_FORMAT(SEC_TO_TIME(duree_film*60), '%lh%i') AS duree, 
                    CONCAT(prenom_real, ' ', nom_real) AS realisateur,
                    GROUP_CONCAT(g.id_genre SEPARATOR ' - ') AS genre
                FROM film f, realisateur r, appartenir a, genre g
                WHERE f.id_real = r.id_real
                AND a.id_film = f.id_film
                AND a.id_genre = g.id_genre
                GROUP BY f.id_film
                ORDER BY date_sortie DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
    /**
     * Retourne le film en base de données correspondant à l'id en paramètre
     * 
     * @param int $id l'identifiant du film en BDD
     * @return array|false un tableau contenant les champs du film ou FALSE si aucun film n'a été récupéré
     * dans l'ordre : id, titre, année, duree, realisateur, resume, affiche, note, [genres]
     */
    function findFilmById($id)
    {
        $db = connexion();
        $sql = "SELECT f.id_film AS id, 
                titre_film AS titre, 
                DATE_FORMAT(date_sortie, '%d/%m/%Y') AS annee, 
                TIME_FORMAT(SEC_TO_TIME(duree_film*60), '%lh%i') AS duree, 
                CONCAT(prenom_real, ' ', nom_real) AS realisateur,
                resume_film AS resume,
                affiche_film AS affiche,
                note_film AS note,
                GROUP_CONCAT(g.id_genre SEPARATOR ' - ') AS genre
            FROM film f, realisateur r, appartenir a, genre g
            WHERE f.id_film = :id
            AND a.id_film = f.id_film
            AND a.id_genre = g.id_genre
            AND f.id_real = r.id_real";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * retourne un tableau des films et roles joués par un acteur
     * @param int $id - identifiant de l'acteur
     * @return array|false
     * dans l'ordre id (film), titre, role, annee
     */
    function findRolesOfActor($id){
        $db = connexion();
        $sql = "SELECT f.id_film AS id,
                titre_film AS titre,
                nom_role AS role, 
                DATE_FORMAT(date_sortie, '%d/%m/%Y') AS annee
            FROM role r, acteur a, jouer j, film f
            WHERE j.id_film = f.id_film
            AND j.id_acteur = a.id_acteur
            AND j.id_role = r.id_role
            AND a.id_acteur = :id
            ORDER BY date_sortie DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * Retourne tout le casting d'un film
     * @return array|false 
     * Renvoie un tableau contenant les acteurs sous forme de tableau,
     * dans l'ordre : id, nomRole, acteur
     * un tableau vide si aucun acteur n'est présent pour ce film
     * ou FALSE si la requète a échoué
     */
    function findAllActorsinFilm($id)
    {
        $db = connexion();
        $sql = "SELECT a.id_acteur AS id,
                nom_role AS nomRole, 
                CONCAT(prenom_acteur, ' ', nom_acteur) AS acteur
            FROM role r, acteur a, jouer j, film f
            WHERE j.id_film = f.id_film
            AND j.id_acteur = a.id_acteur
            AND j.id_role = r.id_role
            AND f.id_film = :id
            ORDER BY nom_acteur";    
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