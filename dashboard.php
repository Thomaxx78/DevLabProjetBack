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
    if (isset($_POST["addAlbum"])) {
        $album = new Album(
            $_POST['name'],
            $_POST['privacy'],
            $_SESSION['id'],
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

<body>
    <?php
        if (!isset($_SESSION['role']) && $_SESSION['role'] != 1) {
            header('Location:login.php');
        }

        require_once 'require/nav.php';
    ?>
    <div class="flex flex-row items-center">
        <img class="w-20 h-20 object-cover rounded-full" src="images/avatars/<?php echo $_SESSION['logo'];?>" alt="">
        <h1> Bienvenu(e) à toi <?php echo $_SESSION['username'];?></h1>
    </div>

    <div class="flex flex-col gap-2">
        <h2>A propos de moi : </h2>
        <p><?php echo $_SESSION['description'];?></p>
    </div>
    <br>

    <div>
        <h1>Créer un nouvel album</h1>
        <form method="POST">
            <div>
                <label for="name">Nom de l'album</label>
                <input type="text" name="name" id="name" placeholder="Ex: Mes favs">
            </div>
            <div>
                <label for="privacy">Confidentialité</label>
                <select class="privacy_select" name="privacy" id="privacy">
                    <option value="interdit">Choisissez la confidentialité </option>
                    <option value="public">Public</option>
                    <option value="private">Privé</option>
                </select>
            </div>
            <button type="submit" name="addAlbum">Enregistrer</button>
        </form>
    </div>
    <br>

    <?php
    require_once 'class/connection.php';
    require_once 'class/user.php';

    
    ?>

    <div>
        <h2>Mes Albums</h2>
        <div class="flex flex-row gap-8 m-8">
            <?php foreach ($allalbums as $album) { ?>
                <?php if ($_SESSION['id']==$album['user_id']){ ?>
                    <div class="flex flex-col bg-gray-300 p-4">
                        <span class="font-bold"> <?= $album['name']?></span>
                        <span>Statut : <?=$album['privacy']?></span>
                        <a href="album.php?id=<?= $album['id']?>">Voir l'album</a>
                        <form class="flex justify-center" method="POST" action="dashboard.php">
                            <input type="hidden" name="delete_album" value="<?= $album["id"]; ?>">
                            <input class="mt-4 text-center bg-gray-100 rounded py-1 px-2" type="submit" name="deleteAlbum" value="supprimer">
                        </form>
                    </div>
                    <br>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div>
        <h2>Autres utilisateurs </h2>
        <?php
        $connection = new Connection();
        $users = $connection->GetUsers();

        foreach ($users as $user): ?>
                <div>
                    <h3><?= $user['username']?></h3>
                    <div>
                    <a href="profil.php?id=<?php echo $user['id']?>">Voir le compte</a>
                    </div>
                </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>
