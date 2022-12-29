<?php
    require_once 'class/connection.php';
    require_once 'class/album.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <main>
        <div>
            <h2>Ajouter à un album</h2>
            <form method="GET">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <select name="albumChoice" id="albumChoice">
                    <?php 
                        $connection = new Connection();
                        $albums = $connection->getAlbumFromID(10);
                        var_dump($albums);
                        foreach($albums as $album){
                            echo '<option value="' . $album['id'] . '">' . $album['name'] . '</option>';
                        }
                    ?>
                </select>
                <input type="submit" value="Ajouter">
            </form>
            <?php

                if(isset($_GET['albumChoice'])){
                    $connection = new Connection();
                    $connection->verifyMovie($_GET['id']);
                    $connection->addMovieToAlbum($_GET['id'], $_GET['albumChoice']);
                }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
        <script type="module" src="js/takeDetails.js"></script>
    </main>
</body>
</html>