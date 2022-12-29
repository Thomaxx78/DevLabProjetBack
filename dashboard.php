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
        <img src="images/avatars/<?php echo $_SESSION['logo'];?>" alt="">
        <h1> Bienvenu(e) à toi <?php echo $_SESSION['username'];?></h1>
    </div>

    <div class="flex flex-row gap-2">
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
        <?php foreach ($allalbums as $album) { ?>
            <?php if ($_SESSION['id']==$album['user_id']){ ?>
                <div>
                    <p> <?= $album['name'] .' - '. $album['privacy']?><p>
                    <form method="POST" action="dashboard.php">
                        <input type="hidden" name="delete_album" value="<?= $album["id"]; ?>">
                        <input type="submit" name="deleteAlbum" value="supprimer">
                    </form>
                </div>
                <br>
            <?php } ?>
        <?php } ?>
    </div>
    <br>
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
