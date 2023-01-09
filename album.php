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
<body class="bg-violetwe">
    <header>
        <?php require_once 'require/nav.php'; ?>
    </header>
    
    <main class="w-full h-auto flex flex-col justify-center items-center">
        <?php
            $album = $connection->getAlbum($_GET['id'])[0];
            // var_dump($album);
            if($album == null){
                header ('Location:index.php');
            }

            $owner = $connection->GetSingleUser($album['user_id'])[0];
        ?>
        <div class="lg:mx-24 bg-darkgrey p-8 mt-8 rounded-lg lg:w-auto w-10/12 m-auto">
            <div>
                <p class="text-center text-white text-2xl lg:text-3xl font-bold"><?= $album['name'];?></p>
            </div>
            <div>
                <p class="text-center text-lightgrey"><?= $owner["username"]?></p>
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

        <div id="divParentAlbum" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 p-5 gap-8">
            <?php
                $allMovies = $connection->getMoviesFromAlbum($album['id']);
                if(empty($allMovies)){
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
            showMoviesByIDs(<?php echo json_encode($array_movies_id);?>, <?php if($owner["id"] == $_SESSION['id'] || $connection->isShared($_GET['id'], $_SESSION['id'])){ echo 'true';}else{echo 'false';};?>);
        </script>
    </main>
</body>
</html>