<?php 
    session_start();
    require_once 'class/connection.php';
    require_once 'class/album.php';
    $connection = new Connection();

    if (!isset($_SESSION['username'])) {
        header('Location:login.php');
    } 
    if(!isset($_GET['id'])){
        header('Location:index.php');
    } 

    $privacity = $connection->getAlbum($_GET['id'])[0]['privacy'];

    if($privacity == "private"){
        $album = $connection->getAlbum($_GET['id'])[0];
        $owner = $connection->GetSingleUser($album['user_id'])[0];
        if($owner['id'] != $_SESSION['id'] && $connection->isShared($_GET['id'], $_SESSION['id']) == false){
            header('Location:index.php');
        }
    }

    if(isset($_POST["removeId"])){
        $delete = $connection->removeMovieFromAlbum($_POST["removeId"], $_GET['id']);
        if($delete){
            header('Location: album.php?id='.$_GET['id']);
        }else{
            echo "Erreur dans la supression";
        }
    }


    require 'require/head.php';
?>
<body>
    <header>
        <?php require_once 'require/nav.php'; ?>
    </header>
    <main>
        <?php
            $album = $connection->getAlbum($_GET['id'])[0];
            // var_dump($album);
            if($album == null){
                header ('Location:index.php');
            }

            $owner = $connection->GetSingleUser($album['user_id'])[0];
        ?>
        <div class="flex flex-col gap-4">
            <h2>Informations</h2>
            <div>
                <h3>Nom de l'album</h3>
                <p><?= $album['name'];?></p>
            </div>
            <div>
                <h3>Créateur</h3>
                <p><?= $owner["username"]?></p>
            </div>
            <div>
                <h3>Visibilité</h3>
                <p><?= $album['privacy'];?></p>
            </div>
            <div>
                <h3>Nombre de likes</h3>
                <p><?= $connection->countLikes($_GET['id'])?></p>
                <form method="POST">
                    <input type="hidden" name="like_album" id="like_album" value="<?= $album['id'];?>">
                    <button type="submit">Liker l'album</button>
                </form>
            </div>
        </div>
        <div id="divParentAlbum" class="flex flex-row gap-20">
            <?php
                $allMovies = $connection->getMoviesFromAlbum($album['id']);
                if($allMovies == null){
                    echo '<h1>Cet album est vide</h1>';
                }
                $array_movies_id = [];
                foreach($allMovies as $movie){
                    array_push($array_movies_id, $movie[0]["film_id"]);
                }
            ?>
        </div>

        <?php
            if(isset($_POST['like_album'])){
                $connection->likeAlbum($_POST['like_album'], $_SESSION['id']);
                header("Refresh:0");
            }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
        <script src="js/album.js"></script>
        <script>
            showMoviesByIDs(<?php echo json_encode($array_movies_id);?>);
        </script>
    </main>
</body>
</html>