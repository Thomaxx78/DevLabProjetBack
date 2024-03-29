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
<body class="bg-violetwe">
    <?php
        if (!isset($_SESSION['username'])) {
            header('Location:login.php');
        }
        
        require_once 'require/nav.php';
    ?>
    <div class=" lg:mx-24 bg-darkgrey p-8 mt-8 rounded-lg lg:w-auto w-10/12 m-auto">
    <div class="flex flex-col lg:flex-row lg:mt-8 items-center">
        <img class="lg:w-64 lg:h-64 w-32 h-32 lg:ml-8 object-cover rounded-full shadow-lg" src="images/avatars/<?php echo $user[0]['logo']?>" alt="">
        <div class=" flex flex-col items-center lg:items-start lg:ml-4 text-white">
            <h1 class="hidden lg:block text-xl font-semibold ml-1">Profil</h1>
            <h1 class="lg:text-7xl text-3xl font-bold"><?= $user[0]['username']?></h1>
            <p class="text-center lg:text-left lg:block lg:ml-1 mt-4 w-full lg:w-10/12"><?= htmlspecialchars_decode($user[0]['description'])?></p>
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
        <div class="lg:ml-16 mt-8">
            <h2 class="text-white text-2xl lg:text-3xl font-bold">Albums publiques</h2>
            <div class="flex lg:flex-row flex-col gap-4 lg:gap-8 mt-8 items-center">
                    <?php foreach ($albums as $album):
                        if($album['privacy'] == "public"):?>
                        <div class="flex flex-col rounded-lg border border-white w-8/12 lg:w-2/12 pb-4">
                            <p class="text-center font-bold m-auto mt-4 text-white text-xl"><?=$album['name']?></p>
                            <a class="text-white m-auto font-semibold" href="album.php?id=<?=($album['id'])?>">Voir</a>
                        </div>
                    <?php  endif; endforeach; ?>
            </div>
        </div>
        <div class="lg:ml-16 mt-8">
            <h2 class="text-white text-2xl lg:text-3xl font-bold">Albums partagés</h2>
            <div>
                <?php 
                $albumsShare = $connection->getSharedAlbums($userId);
				foreach ($albumsShare as $albumShare){
                    $share = $connection->wantToShare($albumShare['id'], $_GET['id']);
                    if($albumShare['privacy'] == "public" and $share==1){?>
                        <p><?=$albumShare['name']?></p>
                        <a href="album.php?id=<?=($albumShare['id'])?>">Voir l'album</a>
				<?php }}?>
            </div>
        </div>
        <?php if($_SESSION['id'] != $userId){?>
            <div class="text-white lg:ml-16">
                <h2 class="text-white text-2xl lg:text-3xl font-bold mt-8">Partager un album</h2>
                <form method="POST">
                    <select class="text-white text-lg bg-darkgrey mt-8"name="shareAlbum" id="shareAlbum">
                        <?php 
                        $myAlbums = $connection->getAlbumFromID($_SESSION['id']);
                        foreach ($myAlbums as $myAlbum):?>
                            <option value="<?=$myAlbum['id']?>"><?=$myAlbum['name']?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="text-white border border-white p-1 rounded-lg lg:ml-4">Partager</button>
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

        <div class="mt-8 lg:ml-16">
            <h2 class="text-white text-2xl lg:text-3xl font-bold"> Ses albums likés </h2>
            <div class="flex lg:flex-row flex-col gap-8 mt-8 ml-4 lg:ml-0">
                <?php foreach ($allalbumslikes as $albumlike) { ?>
                    <?php if ($_SESSION['id']==$albumlike['user_id']){ ?>
                        <div class="flex flex-col rounded-lg border border-white w-8/12 lg:w-2/12 pb-4">
                            <span class="font-bold m-auto mt-4 text-white text-xl"> <?= $albumlike['name']?></span>
                            <a href="album.php?id=<?= $albumlike['album_id']?>" class="text-white m-auto font-semibold">Voir</a>
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
