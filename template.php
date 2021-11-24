<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="files/style.css">
    <title><?=$titre?></title>
</head>
<header>
        Pour voir tous les films par&nbsp;:  
        <nav>
            <a href="genre.php">Genre</a>
            <a href="realisateur.php">Réalisateur</a>
            <a href="index.php">Date de sortie</a>
        </nav>
        <= cliquez sur les liens
    </div>
</header>
<body>
    <div class="wrapper1">
        <div class="wrapper2">
            <div class="wrapper3">
                <?= $result ?>
            </div>
        </div>
    </div>
</body>
<div class ="admin"><a href="admin.php">_</a></div>
</html>