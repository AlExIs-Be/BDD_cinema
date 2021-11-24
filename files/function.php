<?php
    /**
     * @return $table  -  retourne un tableau HTML avec entêtes
     * @param array $array       - tableau des valeurs à afficher
     * @param array $array_titre - tableau des entêtes associés aux valeurs à afficher 
     */
    function afficherTable($array, $array_titre){
        $table = "<table><thead><tr>";
        foreach($array_titre as $entete){
            $table .= "<th>$entete</th>";
        }
        $table .= "</tr></thead><tbody>";
        foreach($array as $item){
            $table .= "<tr>";
            foreach($item as $key=>$value){
                $id = $item["id"];
                switch ($key){
                    case "id":
                        break;
                    case "realisateur":
                        $table .= "<td><a href='realisateur.php?film=$id'>$value</a></td>";
                        break;
                    case "acteur":
                        $table .= "<td><a href='acteur.php?acteur=$id'>$value</a></td>";
                        break;
                    case "titre":
                        $table .= "<td><a href='film.php?film=$id'>$value</a></td>";
                        break;
                    case "genre":
                        $tab = triGenre($value);
                        $table .= "<td>";
                        foreach($tab as $id_genre => $genre){
                            $table .= "<a href='genre.php?id=$id_genre'>$genre</a>&nbsp;&nbsp;";
                        }
                        $table .= "</td>";
                        break;
                    default:
                        $table .= "<td>$value</td>";
                        break;
                }
            }
            $table .= "</tr>";
        }
        $table .= "</tbody></table>";
        return $table;
    }

    function triGenre(string $genres){
        $tab = explode(" - ", $genres);
        $tabGenre = [];
        foreach($tab as $genre){
            $id = getIdGenre($genre);
            $tabGenre[$id] = $genre;
        }
        return $tabGenre;
    }