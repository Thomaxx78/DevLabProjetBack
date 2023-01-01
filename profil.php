<?php
    session_start();

    require_once "class/connection.php";

    if (isset($_GET['id'])) {
        $connection = new Connection;
        $userId = $_GET['id'];
        $user = $connection->GetSingleUser($userId);
        $found = true;
    } else {
        $found = false;
    }
?>

<?php require 'require/head.php';?>
<body>
    <?php
        if (!isset($_SESSION['username'])) {
            header('Location:login.php');
        }
        
        require_once 'require/nav.php';
    ?>

    <div class="flex flex-row items-center">
        <img src="images/avatars/<?php echo $user[0]['logo']?>" alt="">
        <div class="flex flex-col">
            <h1><?= $user[0]['username']?></h1>
            <p><?= $user[0]['age']?> ans<p>
            <p>A propos : <?= $user[0]['description']?></p>
        </div>
    </div>
    
    <br>

    <?php
        require_once 'class/connection.php';
        require_once 'class/album.php';
        require_once 'class/user.php';
        $connection = new Connection();
        $albums = $connection->getAlbumFromID($userId);
        $allalbumslikes = $connection->getAlbumLikeFromID($_SESSION['id']);
    ?>
        <div>
            <h2>Ses albums</h2>
            <div>
				<?php foreach ($albums as $album):
                    if($album['privacy'] == "public"):?>
                        <p><?=$album['name']?></p>
                        <a href="album.php?id=<?=($album['id'])?>">Voir l'album</a>
				<?php  endif; endforeach; ?>
            </div>
        </div>
        <div>
            <h2>Ses albums partagés</h2>
            <div>
                <?php 
                $albumsShare = $connection->getSharedAlbums($userId);
				foreach ($albumsShare as $albumShare){
                    // var_dump($albumShare);
                    $share = $connection->wantToShare($albumShare['id'], $_GET['id']);
                    if($albumShare['privacy'] == "public" and $share==1){?>
                        <p><?=$albumShare['name']?></p>
                        <a href="album.php?id=<?=($albumShare['id'])?>">Voir l'album</a>
				<?php }}?>
            </div>
        </div>
        <?php if($_SESSION['id'] != $userId){?>
            <div>
                <h2>Partager un album </h2>
                <form method="POST">
                    <select name="shareAlbum" id="shareAlbum">
                        <?php 
                        $myAlbums = $connection->getAlbumFromID($_SESSION['id']);
                        foreach ($myAlbums as $myAlbum):?>
                            <option value="<?=$myAlbum['id']?>"><?=$myAlbum['name']?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Partager l'album</button>
                </form>
                <?php
                    if(isset($_POST['shareAlbum'])){
                        $alreadyShared = $connection->verifyAlbumAlreadyShared($_POST['shareAlbum'], $userId);
                        if(!$alreadyShared){
                            $connection->shareAlbum($_POST['shareAlbum'], $userId, $_SESSION['id']);
                        }
                    }
                ?>  
            </div>
        <?php }?>



        <div>
            <h2> Ses albums likés </h2>
            <div>
                <?php foreach ($allalbumslikes as $albumlike) { ?>
                    <?php if ($_SESSION['id']==$albumlike['user_id']){ ?>
                        <div>
                            <span> <?= $albumlike['name']?></span>
                            <a href="album.php?id=<?= $albumlike['album_id']?>">Voir</a>
                        </div>
                        <br>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>
