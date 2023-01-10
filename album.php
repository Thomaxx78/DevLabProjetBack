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

    if(isset($_POST["deleteAlbum"])){
        $delete = $connection->deleteAlbum($_POST["delete_album"]);
        if($delete){
            header('Location: dashboard.php');
        }else{
            echo "Erreur dans la supression";
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

    if(isset($_POST['like_album'])){
        $connection->likeAlbum($_POST['like_album'], $_SESSION['id']);
        header("Refresh:0");
    }

    require 'require/head.php';
?>
<body class="bg-gray-300">
    <header>
        <?php require 'require/nav.php' ?>
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
        <div class="w-4/5 flex flex-col justify-center items-center bg-[#959acc] gap-5 m-5 p-3 rounded-lg shadow-md ">
            <div class="flex flex-col justify-center items-center ">
                <h1 class="text-[26px] font-semibold "><?= $album['name'];?></h1>
                <h2 class="text-[18px] font-style: italic">de <?= $owner["username"]?></h2>
            </div>

                <div class="flex flex-row gap-10">
                    <div class="flex flex-col items-center">
                        <?php if ($album['privacy'] == "private" ){ ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11.885 14.988l3.104-3.098.011.11c0 1.654-1.346 3-3 3l-.115-.012zm8.048-8.032l-3.274 3.268c.212.554.341 1.149.341 1.776 0 2.757-2.243 5-5 5-.631 0-1.229-.13-1.785-.344l-2.377 2.372c1.276.588 2.671.972 4.177.972 7.733 0 11.985-8.449 11.985-8.449s-1.415-2.478-4.067-4.595zm1.431-3.536l-18.619 18.58-1.382-1.422 3.455-3.447c-3.022-2.45-4.818-5.58-4.818-5.58s4.446-7.551 12.015-7.551c1.825 0 3.456.426 4.886 1.075l3.081-3.075 1.382 1.42zm-13.751 10.922l1.519-1.515c-.077-.264-.132-.538-.132-.827 0-1.654 1.346-3 3-3 .291 0 .567.055.833.134l1.518-1.515c-.704-.382-1.496-.619-2.351-.619-2.757 0-5 2.243-5 5 0 .852.235 1.641.613 2.342z"/></svg>
                        <?php } else { ?> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.657-1.343 3-3 3s-3-1.343-3-3c0-.199.02-.393.057-.581 1.474.541 2.927-.882 2.405-2.371.174-.03.354-.048.538-.048 1.657 0 3 1.344 3 3zm-2.985-7c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 12c-2.761 0-5-2.238-5-5 0-2.761 2.239-5 5-5 2.762 0 5 2.239 5 5 0 2.762-2.238 5-5 5z"/></svg>
                        <?php } ?>
                        <p><?= $album['privacy'];?></p>
                    </div>
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 4.419c-2.826-5.695-11.999-4.064-11.999 3.27 0 7.27 9.903 10.938 11.999 15.311 2.096-4.373 12-8.041 12-15.311 0-7.327-9.17-8.972-12-3.27z"/></svg>
                        <p><?= $connection->countLikes($_GET['id'])?></p>
                    </div>
                </div>
        </div>

        <div>
            <?php if($album['user_id'] != $_SESSION['id']){ ?>
                <form method="POST">
                    <input type="hidden" name="like_album" id="like_album" value="<?= $album['id'];?>">
                    <button class="bg-transparent hover:bg-[#646ECB] text-violetwe font-semibold hover:text-white py-2 px-4 border border-[#646ECB] hover:border-transparent rounded" type="submit">Liker l'album</button>
                </form>
            <?php }else{ ?>
                <form method="POST">
                    <input type="hidden" name="delete_album" id="delete_album" value="<?= $album['id'];?>">
                    <input class="bg-transparent hover:bg-[#646ECB] text-violetwe font-semibold hover:text-white py-2 px-4 border border-[#646ECB] hover:border-transparent rounded" type="submit" name="deleteAlbum" value="supprimer">
                </form>
            <?php } ?>
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

        <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
        <script src="js/album.js"></script>
        <script>
            showMoviesByIDs(<?php echo json_encode($array_movies_id);?>, <?php if($owner["id"] == $_SESSION['id'] || $connection->isShared($_GET['id'], $_SESSION['id'])){ echo 'true';}else{echo 'false';};?>);
        </script>
    </main>
</body>
</html>