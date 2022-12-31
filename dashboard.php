<?php
    session_start();
    require_once 'class/connection.php';
    require_once 'class/album.php';

    if(isset($_POST["deleteAlbum"])){
        $connection = new Connection();
        $delete = $connection->deleteAlbum($_POST["delete_album"]);
        if($delete){
            header('Location: dashboard.php');
        }else{
            echo "Erreur dans la supression";
        }
    }

    $connection = new Connection();
    $allalbums = $connection->getAlbumFromID($_SESSION['id']);
    $allalbumslikes = $connection->getAlbumLikeFromID($_SESSION['id']);

    if (isset($_POST["addAlbum"])) {
        $album = new Album(
            $_POST['name'],
            $_POST['privacy'],
            $_SESSION['id'],
            $_SESSION['likes'],
        );

        $connection = new Connection();
        $ajout = $connection->insertAlbum($album);
        if ($ajout) {
            echo 'Album Crée';
            header('Location: dashboard.php');
        } else {
            echo 'Echec 🥲';
        }
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

    <div class="lg:mx-24 bg-darkgrey p-8 mt-8 rounded-lg w-10/12 m-auto">
        <div class="flex  lg:mt-8 items-center">
            <img class="lg:w-64 lg:h-64 w-32 h-32 lg:ml-8 object-cover rounded-full shadow-lg" src="images/avatars/<?php echo $_SESSION['logo'];?>" alt="">
            <div class="ml-4 text-white">
                <h1 class="hidden lg:block text-xl font-semibold ml-1">Profil</h1>
                <h1 class="lg:text-7xl text-3xl font-bold"> <?php echo $_SESSION['username'];?></h1>
                <p class="hidden lg:block lg:ml-1 mt-4 w-full lg:w-10/12"><?php echo $_SESSION['description'];?></p>
        </div>
    </div>
        <div class="lg:ml-8 mt-16">
            <h2 class="text-white text-2xl lg:text-3xl font-bold">Mes Albums:</h2>
            <h3 class="text-lightgrey text-base lg:text-xl">Vos albums publiques sont visibles par tous.</h3>
            <div class="flex lg:flex-row flex-col gap-8 mt-8 ml-4 lg:ml-0">
                <?php foreach ($allalbums as $album) { ?>
                    <?php if ($_SESSION['id']==$album['user_id']){ ?>
                        <div class="flex flex-col px-4 pb-2 rounded-lg border border-white w-8/12 lg:w-2/12">
                            <span class="mt-2 text-gray-400"><?=$album['privacy']?></span>
                            <span class="font-bold m-auto mt-4 text-white text-xl"> <?= $album['name']?></span>
                            <a href="album.php?id=<?= $album['id']?>" class="text-white m-auto font-semibold ">Voir</a>
                            <form class="mr-0 ml-auto" method="POST" action="dashboard.php">
                                <input type="hidden" name="delete_album" value="<?= $album["id"]; ?>">
                                <input class=" text-center rounded w-4 h-4 mt-4" type="image" name="deleteAlbum" src="public/supprimer.png">
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
                <?php foreach ($allalbumslikes as $albumlike) { ?>
                    <?php if ($_SESSION['id']==$albumlike['user_id']){ ?>
                        <div class="flex flex-col px-4 pb-2 rounded-lg border border-white w-8/12 lg:w-2/12">
                            <span class="font-bold m-auto mt-4 text-white text-xl"> <?= $albumlike['name']?></span>
                            <a href="album.php?id=<?= $albumlike['album_id']?>" class="text-white m-auto font-semibold ">Voir</a>
                        </div>
                        <br>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    

        <div class="ml-0 lg:ml-8 mt-16">
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
                <button type="submit" name="addAlbum" class="text-white mt-8 border-2 border-white rounded-lg w-4/12 m-auto">Enregistrer</button>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>
