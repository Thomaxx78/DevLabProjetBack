<?php
    session_start();
    require_once 'class/connection.php';
    require_once 'class/album.php';
    $connection = new Connection();

    if(isset($_POST["deleteAlbum"])){
        $delete = $connection->deleteAlbum($_POST["delete_album"]);
        if($delete){
            header('Location: dashboard.php');
        }else{
            echo "Erreur dans la supression";
        }
    }

    if (isset($_POST["addAlbum"])) {
        $album = new Album(
            $_POST['name'],
            $_POST['privacy'], 
            $_SESSION['id'],
            $_SESSION['likes'],
        );

        $ajout = $connection->insertAlbum($album);
        if ($ajout) {
            echo 'Album Crée';
            header('Location: dashboard.php');
        } else {
            echo 'Echec 🥲';
        }
    }

    if(isset($_POST["accept"]) || isset($_POST["refuse"])){
        if(isset($_POST["accept"])){
            $accept = $connection->acceptShare($_POST["accept"]);
        } else{
            $refuse = $connection->refuseShare($_POST["refuse"]);
        }
        // header('Location: dashboard.php'); 
    }
?>
<?php require 'require/head.php';?>

<body class="bg-violetwe">
    <?php
        if (!isset($_SESSION['username'])) {
            header('Location: login.php');
        }

        require_once 'require/nav.php';
    ?>

    <div class="lg:mx-24 bg-darkgrey p-8 mt-8 rounded-lg lg:w-auto w-10/12 m-auto">
        <div class="flex  lg:mt-8 items-center">
            <img class="lg:w-64 lg:h-64 w-32 h-32 lg:ml-8 object-cover rounded-full shadow-lg" src="images/avatars/<?php echo $_SESSION['logo'];?>" alt="">
            <div class="flex flex-row justify-between">
                <div class="ml-4 text-white">
                    <h1 class="hidden lg:block text-xl font-semibold ml-1">Profil</h1>
                    <h1 class="lg:text-7xl text-3xl font-bold"> <?php echo $_SESSION['username'];?></h1>
                    <p class="hidden lg:block lg:ml-1 mt-4 w-full lg:w-10/12"><?php echo $_SESSION['description'];?></p>
                </div>
                <div class="text-white w-6/12">
                    <h3 class="block text-xl font-semibold">Mes notifications</h3>
                    <div class="flex flex-col gap-4 mt-8">
                        <?php
                            $allnotifications = $connection->getNotificationFromID($_SESSION['id']);
                            foreach ($allnotifications as $notification) {
                                // var_dump($notification["album"][0]["name"]);
                                $userAlbum = $connection->GetSingleUser($notification['id_user']);
                                ?>
                                <span><?= $userAlbum[0]["username"];?> souhaite partager avec toi un album intitulé "<?= $notification["album"][0]["name"];?>"</span>
                                <div class="flex flex-row gap-8">
                                    <form method="POST">
                                        <input type="hidden" name="accept" value="<?= $notification["id"]; ?>">
                                        <button type="submit">Accepter</button>
                                    </form>
                                    <form method="POST">
                                        <input type="hidden" name="refuse" value="<?= $notification["id"]; ?>">
                                        <button type="submit">Décliner</button>
                                    </form>
                                </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:ml-8 mt-16">
            <h2 class="text-white text-2xl lg:text-3xl font-bold">Mes Albums:</h2>
            <h3 class="text-lightgrey text-base lg:text-xl">Vos albums publiques sont visibles par tous.</h3>

            <div class="carousel" data-flickity='{ "groupCells": true }'>
        <?php 
                    $allalbums = $connection->getAlbumFromID($_SESSION['id']);
                    foreach ($allalbums as $album) {
                        if ($_SESSION['id']==$album['user_id']){ ?>
                            <div class="flex flex-col w-3/12 h-64 mr-10 border border-lg">
                                <span class="text-xl ml-4 mt-4 text-gray-400"><?=$album['privacy']?></span>
                                <div class="flex flex-col m-auto">
                                    <span class="text-center font-bold text-white text-3xl"> <?= $album['name']?></span>
                                    <a href="album.php?id=<?= $album['id']?>" class="text-white text-center font-semibold">Voir</a>
                                </div>
                                <form class="mr-4 ml-auto mb-4" method="POST" action="dashboard.php">
                                    <input type="hidden" name="delete_album" value="<?= $album["id"]; ?>">
                                    <button class=" rounded w-6 h-6 " type="submit" name="deleteAlbum"><img src="public/supprimer.png" alt=""></button>
                                </form>
                            </div>
                            <br>
                        <?php } ?>
                    <?php } ?>
           
        </div>
        
        </div>

        <div class="lg:ml-8 mt-16">
            <h2 class="text-white text-2xl lg:text-3xl font-bold">Mes Albums likés:</h2>
            <div class="flex lg:flex-row flex-col gap-8 mt-8 ml-4 lg:ml-0">
                <?php 
                $allalbumslikes = $connection->getAlbumLikeFromID($_SESSION['id']);
                foreach ($allalbumslikes as $albumlike) {
                    if ($_SESSION['id']==$albumlike['user_id']){ ?>
                        <div class="flex flex-col px-4 pb-2 rounded-lg border border-white w-8/12 lg:w-2/12">
                            <span class="font-bold m-auto mt-4 text-white text-xl"> <?= $albumlike['name']?></span>
                            <a href="album.php?id=<?= $albumlike['album_id']?>" class="text-white m-auto font-semibold ">Voir</a>
                        </div>
                        <br>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    
        <div class="lg:ml-8 mt-16">
            <h2 class="text-white text-2xl lg:text-3xl font-bold">Mes Albums partagés:</h2>
            <div class="flex lg:flex-row flex-col gap-8 mt-8 ml-4 lg:ml-0">
                <?php 
                $albumsShare = $connection->getSharedAlbums($_SESSION['id']);
                foreach ($albumsShare as $albumShare) {?>
                    <div class="flex flex-col px-4 pb-2 rounded-lg border border-white w-8/12 lg:w-2/12">
                        <span class="font-bold m-auto mt-4 text-white text-xl"><?= $albumShare['name']?></span>
                        <a href="album.php?id=<?= $albumShare['id']?>" class="text-white m-auto font-semibold ">Voir</a>
                    </div>
                    <br>
                <?php } ?>
            </div>
        </div>

        <div class="ml-0 lg:ml-8 mt-4 lg:mt-16">
            <h1 class="text-white text-2xl lg:text-3xl font-bold">Créer un album:</h1>
            <form method="POST" class="mt-8 flex flex-col py-4 px-4 pb-4 rounded-lg border border-white lg:w-4/12">
                <div class="">
                    <label for="name" class="text-white text-xl font-semi-bold mr-2">Nom:</label>
                    <input class="w-6/12 bg-darkgrey border-b border-white"type="text" name="name" id="name" placeholder="Ex: Mes favs">
                </div>
                <div class="flex mt-4">
                    <label for="privacy" class="text-white text-xl mr-2">Confidentialité:</label>
                    <select class="privacy_select bg-darkgrey text-white border border-white rounded-lg" name="privacy" id="privacy">
                        <option value="interdit">Choisir</option>
                        <option value="public">Public</option>
                        <option value="private">Privé</option>
                    </select>
                </div>
                <button type="submit" name="addAlbum" class="text-white mt-8 border-2 border-white rounded-lg w-6/12 lg:w-4/12 m-auto">Enregistrer</button>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
</body>
</html>
